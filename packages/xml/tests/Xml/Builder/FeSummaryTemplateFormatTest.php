<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use DOMXPath;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use PHPUnit\Framework\TestCase;

/**
 * Formato y ubicación de los campos según las reglas de validación SUNAT
 * (hoja Resumen Diario1_1).
 */
class FeSummaryTemplateFormatTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    private const LINE = '/*/sac:SummaryDocumentsLine[1]';

    /**
     * El nodo del adquiriente es condicional (ERR-2514 solo si el total supera 700),
     * sin cliente no se generan tags vacíos (ERR-2014, ERR-2015).
     */
    public function testSinAdquiriente()
    {
        $summary = $this->createSummary();
        $summary->getDetails()[0]->setClienteTipo(null)->setClienteNro(null);

        $xml = $this->build($summary);
        $xpath = $this->xpath($xml);

        $this->assertSame(0, $xpath->query(self::LINE.'/cac:AccountingCustomerParty')->length);
        $this->assertSame(1, $xpath->query('/*/sac:SummaryDocumentsLine[2]/cac:AccountingCustomerParty')->length);
        $this->assertSchema($xml);
    }

    public function testAdquirienteConRazonSocial()
    {
        $summary = $this->createSummary();
        $summary->getDetails()[0]
            ->setClienteTipo('1')
            ->setClienteNro('45678912')
            ->setClienteNombre('PEREZ & GOMEZ JUAN');

        $xml = $this->build($summary);
        $xpath = $this->xpath($xml);
        $customer = self::LINE.'/cac:AccountingCustomerParty';

        $this->assertSame('45678912', $xpath->evaluate("string($customer/cbc:CustomerAssignedAccountID)"));
        $this->assertSame('1', $xpath->evaluate("string($customer/cbc:AdditionalAccountID)"));
        $this->assertSame('PEREZ & GOMEZ JUAN', $xpath->evaluate("string($customer/cac:Party/cac:PartyLegalEntity/cbc:RegistrationName)"));
        $this->assertSchema($xml);
    }

    public function testAdquirienteSinRazonSocial()
    {
        $xpath = $this->xpath($this->build($this->createSummary()));

        $this->assertSame(0, $xpath->query(self::LINE.'/cac:AccountingCustomerParty/cac:Party')->length);
    }

    /**
     * Operaciones gratuitas por tipo (catálogo 11: 06, 07, 08, 09) e IGV de gratuitas (9996 - GRA).
     */
    public function testOperacionesGratuitasEIgvGratuito()
    {
        $summary = $this->createSummary();
        $summary->getDetails()[0]
            ->setPorcentajeIgv(18)
            ->setMtoOperGratuitasGravadas(100)
            ->setMtoOperGratuitasExoneradas(20.5)
            ->setMtoOperGratuitasInafectas(30)
            ->setMtoOperGratuitasExportacion(40.125)
            ->setMtoIGVGratuitas(18);

        $xml = $this->build($summary);
        $xpath = $this->xpath($xml);
        $payment = self::LINE."/sac:BillingPayment[cbc:InstructionID='%s']/cbc:PaidAmount";

        $this->assertSame('100.00', $xpath->evaluate('string('.sprintf($payment, '06').')'));
        $this->assertSame('20.50', $xpath->evaluate('string('.sprintf($payment, '07').')'));
        $this->assertSame('30.00', $xpath->evaluate('string('.sprintf($payment, '08').')'));
        $this->assertSame('40.13', $xpath->evaluate('string('.sprintf($payment, '09').')'));
        $this->assertSame(0, $xpath->query(self::LINE."/sac:BillingPayment[cbc:InstructionID='05']")->length);

        $tax = self::LINE."/cac:TaxTotal[cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:ID='9996']";
        $this->assertSame(1, $xpath->query($tax)->length);
        $this->assertSame('18.00', $xpath->evaluate("string($tax/cbc:TaxAmount)"));
        $this->assertSame('18.00', $xpath->evaluate("string($tax/cac:TaxSubtotal/cbc:TaxAmount)"));
        $this->assertSame('18.00', $xpath->evaluate("string($tax/cac:TaxSubtotal/cac:TaxCategory/cbc:Percent)"));
        $this->assertSame('GRA', $xpath->evaluate("string($tax/cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:Name)"));
        $this->assertSame('FRE', $xpath->evaluate("string($tax/cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:TaxTypeCode)"));
        // IGV (1000) se mantiene
        $this->assertSame(1, $xpath->query(self::LINE."/cac:TaxTotal[cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:ID='1000']")->length);
        $this->assertSchema($xml);
    }

    public function testGratuitasConsolidadasSinDesglose()
    {
        $summary = $this->createSummary();
        $summary->getDetails()[0]->setMtoOperGratuitas(10);

        $xpath = $this->xpath($this->build($summary));

        $this->assertSame('10.00', $xpath->evaluate('string('.self::LINE."/sac:BillingPayment[cbc:InstructionID='05']/cbc:PaidAmount)"));
        foreach (['06', '07', '08', '09'] as $code) {
            $this->assertSame(0, $xpath->query(self::LINE."/sac:BillingPayment[cbc:InstructionID='$code']")->length);
        }
        $this->assertSame(0, $xpath->query(self::LINE."//cac:TaxScheme[cbc:ID='9996']")->length);
    }

    private function createSummary(): Summary
    {
        /** @var Summary $summary */
        $summary = $this->createDocument(SummaryStore::class);

        $detail = (new SummaryDetail())
            ->setTipoDoc('03')
            ->setSerieNro('B001-10')
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(118)
            ->setMtoOperGravadas(100)
            ->setPorcentajeIgv(18)
            ->setMtoIGV(18);

        $summary->setDetails(array_merge([$detail], $summary->getDetails()));

        return $summary;
    }

    private function xpath(string $xml): DOMXPath
    {
        $doc = new DOMDocument();
        $this->assertTrue($doc->loadXML($xml), 'XML bien formado');
        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $xpath->registerNamespace('sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');

        return $xpath;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder\v21;

use DateTime;
use DateTimeZone;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\Generator\NoteStore;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\DetailAttribute;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use PHPUnit\Framework\TestCase;
use Tests\Greenter\Xml\Builder\FeBuilderTrait;
use Tests\Greenter\Xml\Builder\XsdValidatorTrait;

/**
 * Formato y ubicación de los campos según las reglas de validación SUNAT
 * (hojas Factura2_0, Boleta2_0, NotaCredito2_0 y NotaDebito2_0).
 */
class FeTemplateFormatTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testDetalleFormatoNumerico()
    {
        $invoice = $this->createInvoice();
        $detail = $invoice->getDetails()[1];
        $detail->setPorcentajeIgv(18.123456)
            ->setCargos([(new Charge())->setCodTipo('47')->setMonto(5.123456)->setMontoBase(100.1)])
            ->setDescuentos([(new Charge())->setCodTipo('00')->setFactor(0.05)->setMonto(5.005)->setMontoBase(100)]);

        $xml = $this->build($invoice);
        $xpath = $this->xpath($xml);
        $line = '/*/cac:InvoiceLine[2]';
        
        // n(3,5)
        $this->assertSame('18.12346', $xpath->evaluate("string($line/cac:TaxTotal/cac:TaxSubtotal[cac:TaxCategory/cbc:TaxExemptionReasonCode]/cac:TaxCategory/cbc:Percent)"));
        // n(12,2) y factor opcional (ERR-3052)
        $charge = "$line/cac:AllowanceCharge[cbc:ChargeIndicator='true']";
        $this->assertSame(0, $xpath->query("$charge/cbc:MultiplierFactorNumeric")->length);
        $this->assertSame('5.12', $xpath->evaluate("string($charge/cbc:Amount)"));
        $this->assertSame('100.10', $xpath->evaluate("string($charge/cbc:BaseAmount)"));
        $discount = "$line/cac:AllowanceCharge[cbc:ChargeIndicator='false']";
        $this->assertSame('0.05', $xpath->evaluate("string($discount/cbc:MultiplierFactorNumeric)"));
        $this->assertSame('5.01', $xpath->evaluate("string($discount/cbc:Amount)"));
        $this->assertSchema($xml);
    }

    public function testCargoGlobalSinFactor()
    {
        $invoice = $this->createInvoice();
        $invoice->setCargos([(new Charge())->setCodTipo('50')->setMonto(10)->setMontoBase(100)]);

        $xpath = $this->xpath($this->build($invoice));

        $this->assertSame(0, $xpath->query("/*/cac:AllowanceCharge[cbc:AllowanceChargeReasonCode='50']/cbc:MultiplierFactorNumeric")->length);
    }

    /**
     * @dataProvider gtinProvider
     */
    public function testGtinSchemeId(string $code, ?string $scheme)
    {
        $invoice = $this->createInvoice();
        $invoice->getDetails()[1]->setCodProdGS1($code);

        $xpath = $this->xpath($this->build($invoice));
        $node = $xpath->query('/*/cac:InvoiceLine[2]/cac:Item/cac:StandardItemIdentification/cbc:ID')->item(0);

        $this->assertSame($code, $node->textContent);
        $this->assertSame($scheme ?? '', $node->getAttribute('schemeID'));
    }

    public function gtinProvider(): array
    {
        return [
            ['12345678', 'GTIN-8'],
            ['123456789012', 'GTIN-12'],
            ['7750182002363', 'GTIN-13'],
            ['17750182002360', 'GTIN-14'],
            ['123456789', null],
        ];
    }

    public function testAtributoCantidadYHoraInicio()
    {
        $invoice = $this->createInvoice();
        $invoice->getDetails()[1]->setAtributos([
            (new DetailAttribute())
                ->setCode('3006')
                ->setName('Cantidad de la Especie vendida')
                ->setCantidad(12.5)
                ->setUnidad('TNE'),
            (new DetailAttribute())
                ->setCode('3060')
                ->setName('Hora de inicio programado')
                ->setFecInicio(new DateTime('2026-11-10 08:30:00', new DateTimeZone('America/Lima')))
                ->setHoraInicio(new DateTime('2026-11-10 08:30:00', new DateTimeZone('America/Lima'))),
        ]);

        $xml = $this->build($invoice);
        $xpath = $this->xpath($xml);
        $prop = '/*/cac:InvoiceLine[2]/cac:Item/cac:AdditionalItemProperty';

        $quantity = $xpath->query("{$prop}[cbc:NameCode='3006']/cbc:ValueQuantity")->item(0);
        $this->assertSame('12.50', $quantity->textContent);
        $this->assertSame('TNE', $quantity->getAttribute('unitCode'));
        $this->assertSame('08:30:00', $xpath->evaluate("string({$prop}[cbc:NameCode='3060']/cac:UsabilityPeriod/cbc:StartTime)"));
        $this->assertSchema($xml);
    }

    /**
     * Catálogo 07: la afectación 40 (exportación) y 17 (IVAP) en operaciones gratuitas usan el tributo 9996.
     */
    public function testAfectacionGratuitaExportacion()
    {
        $invoice = $this->createInvoice();
        $invoice->getDetails()[1]->setTipAfeIgv('40')->setMtoValorGratuito(10);
        $invoice->getDetails()[0]->setTipAfeIgv('40');

        $xpath = $this->xpath($this->build($invoice));
        $scheme = 'cac:TaxTotal/cac:TaxSubtotal/cac:TaxCategory[cbc:TaxExemptionReasonCode]/cac:TaxScheme';

        $this->assertSame('9995', $xpath->evaluate("string(/*/cac:InvoiceLine[1]/$scheme/cbc:ID)"));
        $this->assertSame('9996', $xpath->evaluate("string(/*/cac:InvoiceLine[2]/$scheme/cbc:ID)"));
        $this->assertSame('GRA', $xpath->evaluate("string(/*/cac:InvoiceLine[2]/$scheme/cbc:Name)"));
    }

    public function testDireccionesSinTagsVacios()
    {
        $invoice = $this->createInvoice();
        $invoice->getCompany()->setAddress((new Address())->setDireccion('AV LIMA 123'));
        $invoice->getClient()->setAddress((new Address())
            ->setUbigueo('150101')
            ->setUrbanizacion('URB 1')
            ->setProvincia('LIMA PROV')
            ->setDepartamento('LIMA DEP')
            ->setDistrito('LIMA DIST')
            ->setDireccion('JR. NIQUEL 3'));

        $xml = $this->build($invoice);
        $xpath = $this->xpath($xml);
        $emisor = '/*/cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress';
        $cliente = '/*/cac:AccountingCustomerParty/cac:Party/cac:PartyLegalEntity/cac:RegistrationAddress';

        foreach (['cbc:ID', 'cbc:CityName', 'cbc:CountrySubentity', 'cbc:District'] as $tag) {
            $this->assertSame(0, $xpath->query("$emisor/$tag")->length, $tag);
        }
        $this->assertSame('URB 1', $xpath->evaluate("string($cliente/cbc:CitySubdivisionName)"));
        $this->assertSame('LIMA PROV', $xpath->evaluate("string($cliente/cbc:CityName)"));
        $this->assertSame('LIMA DEP', $xpath->evaluate("string($cliente/cbc:CountrySubentity)"));
        $this->assertSame('LIMA DIST', $xpath->evaluate("string($cliente/cbc:District)"));
        $this->assertSchema($xml);
    }

    public function testCuotaSinFechaNoSeInventa()
    {
        $invoice = $this->createInvoice();
        $invoice->setCuotas([(new Cuota())->setMonto(10)]);

        $xpath = $this->xpath($this->build($invoice));

        $this->assertSame(0, $xpath->query("/*/cac:PaymentTerms[cbc:PaymentMeansID='Cuota001']/cbc:PaymentDueDate")->length);
    }

    public function testNotaCreditoTextoLibreEIcbper()
    {
        $note = $this->createNote();
        $note->setDesMotivo('DEVOLUCION <PARCIAL> & DESCUENTO');
        $note->getCompany()->setNombreComercial(null);
        $note->getDetails()[0]
            ->setUnidad('ZZ')
            ->setIcbper(1)
            ->setFactorIcbper(0.5);

        $xml = $this->build($note);
        $xpath = $this->xpath($xml);

        $this->assertSame('DEVOLUCION <PARCIAL> & DESCUENTO', $xpath->evaluate('string(/*/cac:DiscrepancyResponse/cbc:Description)'));
        $this->assertSame(0, $xpath->query('/*/cac:AccountingSupplierParty/cac:Party/cac:PartyName')->length);
        $measure = $xpath->query('/*/cac:CreditNoteLine/cac:TaxTotal/cac:TaxSubtotal/cbc:BaseUnitMeasure')->item(0);
        $this->assertSame('NIU', $measure->getAttribute('unitCode'));
        $this->assertSame('2', $measure->textContent);
        $this->assertSchema($xml);
    }

    public function testNotaDebitoConDetraccion()
    {
        $note = $this->createNote();
        $note->setTipoDoc('08')
            ->setCodMotivo('02')
            ->setDetraccion((new Detraction())
                ->setCodBienDetraccion('037')
                ->setCodMedioPago('001')
                ->setCtaBanco('0004-3342343243')
                ->setPercent(12)
                ->setMount(28.32));

        $xml = $this->build($note);
        $xpath = $this->xpath($xml);

        $this->assertSame('0004-3342343243', $xpath->evaluate("string(/*/cac:PaymentMeans[cbc:ID='Detraccion']/cac:PayeeFinancialAccount/cbc:ID)"));
        $this->assertSame('001', $xpath->evaluate("string(/*/cac:PaymentMeans[cbc:ID='Detraccion']/cbc:PaymentMeansCode)"));
        $terms = "/*/cac:PaymentTerms[cbc:ID='Detraccion']";
        $this->assertSame('037', $xpath->evaluate("string($terms/cbc:PaymentMeansID)"));
        $this->assertSame('12', $xpath->evaluate("string($terms/cbc:PaymentPercent)"));
        $this->assertSame('28.32', $xpath->evaluate("string($terms/cbc:Amount)"));
        $this->assertSame('PEN', $xpath->evaluate("string($terms/cbc:Amount/@currencyID)"));
        $this->assertSchema($xml);
    }

    private function createInvoice(): Invoice
    {
        /** @var Invoice $invoice */
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');

        return $invoice;
    }

    private function createNote(): Note
    {
        /** @var Note $note */
        $note = $this->createDocument(NoteStore::class);
        $note->setUblVersion('2.1');

        return $note;
    }

    private function xpath(string $xml): \DOMXPath
    {
        $doc = new \DOMDocument();
        $this->assertTrue($doc->loadXML($xml), 'XML bien formado');
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        return $xpath;
    }
}

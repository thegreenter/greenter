<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use DOMXPath;
use Greenter\Data\Generator\Despatch2022Store;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Model\Company\Address;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\InvoiceBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Con la opción autoescape de Twig (por defecto 'html' en See y Api) los textos fuera de CDATA
 * se escapan; dentro de CDATA se escriben tal cual (|raw), el usuario es responsable de no
 * incluir la secuencia ']]>'.
 */
class XmlEscapeTest extends TestCase
{
    use SharedBuilderTrait;

    private const CDATA_TEXT = 'ACME & <Hijos> "S.A.C."';
    private const PLAIN_TEXT = 'Av. Lima & "Jr. Cusco" <Int. 2> O\'Higgins';

    /**
     * @dataProvider optionsProvider
     */
    public function testInvoiceCdataValues(array $options): void
    {
        /** @var Invoice $invoice */
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->getCompany()->setRazonSocial(self::CDATA_TEXT);
        $invoice->getDetails()[0]->setDescripcion(self::CDATA_TEXT);

        $xml = (new InvoiceBuilder($options))->build($invoice);
        $xpath = $this->loadXpath($xml);

        $this->assertSame(
            self::CDATA_TEXT,
            $xpath->evaluate('string(/inv:Invoice/cac:AccountingSupplierParty/cac:Party/cac:PartyLegalEntity/cbc:RegistrationName)')
        );
        $this->assertSame(
            self::CDATA_TEXT,
            $xpath->evaluate('string(/inv:Invoice/cac:InvoiceLine[1]/cac:Item/cbc:Description)')
        );
    }

    /**
     * Valores dentro de un {% block %} (cac:PhysicalLocation del adquirente).
     *
     * @dataProvider optionsProvider
     */
    public function testInvoiceBlockValues(array $options): void
    {
        /** @var Invoice $invoice */
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->setDireccionDestino((new Address())
            ->setUbigueo('230101')
            ->setUrbanizacion(self::PLAIN_TEXT)
            ->setDireccion(self::CDATA_TEXT)
            ->setCodigoPais('PE'));

        $xml = (new InvoiceBuilder($options))->build($invoice);
        $xpath = $this->loadXpath($xml);
        $address = '/inv:Invoice/cac:AccountingCustomerParty/cac:Party/cac:PhysicalLocation/cac:Address';

        $this->assertSame(self::PLAIN_TEXT, $xpath->evaluate("string($address/cbc:CitySubdivisionName)"));
        $this->assertSame(self::CDATA_TEXT, $xpath->evaluate("string($address/cac:AddressLine/cbc:Line)"));
    }

    /**
     * @dataProvider optionsProvider
     */
    public function testDespatchPlainValues(array $options): void
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);
        $despatch->getEnvio()->getLlegada()->setDireccion(self::PLAIN_TEXT);
        $despatch->getEnvio()->setDesTraslado(self::PLAIN_TEXT);

        $xml = (new DespatchBuilder($options))->build($despatch);
        $xpath = $this->loadXpath($xml);

        $this->assertSame(
            self::PLAIN_TEXT,
            $xpath->evaluate('string(//cac:Delivery/cac:DeliveryAddress/cac:AddressLine/cbc:Line)')
        );
        $this->assertSame(
            self::PLAIN_TEXT,
            $xpath->evaluate('string(//cac:Shipment/cbc:HandlingInstructions)')
        );
    }

    public function optionsProvider(): array
    {
        return [
            'autoescape html (default See y Api)' => [['cache' => false, 'autoescape' => 'html']],
            'opciones por defecto de Twig' => [['cache' => false]],
        ];
    }

    private function loadXpath(?string $xml): DOMXPath
    {
        $doc = new DOMDocument();
        $this->assertTrue(@$doc->loadXML((string)$xml), 'XML generado inválido');

        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('inv', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        return $xpath;
    }
}

<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use DOMXPath;
use Greenter\Data\Generator\Despatch2022Store;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\InvoiceBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Los textos ingresados por el usuario no deben romper ni inyectar XML.
 */
class XmlEscapeTest extends TestCase
{
    use SharedBuilderTrait;

    private const CDATA_TEXT = 'ACME ]]><cbc:Injected/> & <Hijos>';
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
        $this->assertSame(0, $xpath->query('//cbc:Injected')->length);
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
            'autoescape deshabilitado (default See)' => [['cache' => false, 'autoescape' => false]],
            'autoescape html' => [['cache' => false, 'autoescape' => 'html']],
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

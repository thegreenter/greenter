<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 11/10/2018
 * Time: 18:05
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder\v21;

use Greenter\Data\Generator\InvoiceDiscountStore;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\Generator\InvoiceIcbperStore;
use Greenter\Data\Generator\InvoiceIvapStore;
use Greenter\Data\Generator\InvoicePagoCreditoStore;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Tests\Greenter\Xml\Builder\FeBuilderTrait;
use Tests\Greenter\Xml\Builder\XsdValidatorTrait;
use PHPUnit\Framework\TestCase;

class FeInvoiceBuilderTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testGenerate()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');

        $xml = $this->build($invoice);

//        file_put_contents('x.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
        $this->assertZeroTaxAmountFormat($xml, 3);
    }

    /**
     * Exportación de servicios (0201, 0208): el campo 15, país del uso del
     * servicio, va en cac:Delivery/.../cac:Country, y sin dirección de
     * entrega no se escribe la línea de dirección, que es el campo 14 (venta
     * itinerante) y pide la leyenda 2005 (observación 4266).
     */
    public function testDireccionEntregaSoloConPais()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->setDireccionEntrega((new Address())->setCodigoPais('US'));

        $xml = $this->build($invoice);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $address = '/*/cac:Delivery/cac:DeliveryLocation/cac:Address';

        $this->assertSame('US', $xpath->evaluate("string($address/cac:Country/cbc:IdentificationCode)"));
        $this->assertSame(0, $xpath->query("$address/cac:AddressLine")->length);
        $this->assertSame(0, $xpath->query("$address/cbc:ID")->length);
        $this->assertSame(0, $xpath->query("$address/cbc:CityName")->length);
        $this->assertSchema($xml);
    }

    public function testDireccionEntregaCompletaSeEscribeEntera()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->setDireccionEntrega((new Address())
            ->setUbigueo('150101')->setDistrito('LIMA')->setProvincia('LIMA')->setDepartamento('LIMA')
            ->setDireccion('ALGARROBOS 1650')->setCodigoPais('PE'));

        $xml = $this->build($invoice);

        $this->assertStringContainsString('<cbc:ID>150101</cbc:ID>', $xml);
        $this->assertStringContainsString('<![CDATA[ALGARROBOS 1650]]>', $xml);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testBuilder($invoiceClass)
    {
        $invoice = $this->createDocument($invoiceClass);

        $xml = $this->build($invoice);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function storeProvider()
    {
        return [
            [InvoiceDiscountStore::class],
            [InvoiceIvapStore::class],
            [InvoiceIcbperStore::class],
            [InvoicePagoCreditoStore::class]
        ];
    }
}
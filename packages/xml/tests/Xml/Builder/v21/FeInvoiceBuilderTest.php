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
use Greenter\Model\Sale\TramoTransporte;
use Greenter\Model\Sale\TransporteCarga;
use Greenter\Model\Sale\VehiculoTransporte;
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
     * Incoterm: campo 62 de Factura2_0 (61 de Boleta2_0), /Invoice/cac:DeliveryTerms/cbc:ID.
     * Va después de cac:Delivery y antes de cac:PaymentMeans y cac:PaymentTerms, como pide UBL 2.1.
     */
    public function testIncoterm()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->setDireccionEntrega((new Address())->setCodigoPais('US'));
        $invoice->setIncoterm('FOB');

        $xml = $this->build($invoice);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $this->assertSame('FOB', $xpath->evaluate('string(/*/cac:DeliveryTerms/cbc:ID)'));
        $this->assertSame(1, $xpath->query('/*/cac:Delivery/following-sibling::cac:DeliveryTerms')->length);
        $this->assertSame(0, $xpath->query('/*/cac:PaymentTerms/following-sibling::cac:DeliveryTerms')->length);
        $this->assertSchema($xml);
    }

    public function testSinIncotermNoSeEscribe()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');

        $this->assertStringNotContainsString('<cac:DeliveryTerms>', $this->build($invoice));
    }

    public function testTransporteDeCarga()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');
        $invoice->setTipoOperacion('1004');
        $invoice->getDetails()[0]->setTransporteCarga((new TransporteCarga())
            ->setOrigen((new Address())->setUbigueo('150101')->setDireccion('AV. ARGENTINA 2450, LIMA'))
            ->setDestino((new Address())->setUbigueo('040101')->setDireccion('CALLE MERCADERES 120, AREQUIPA'))
            ->setDetalleViaje('LIMA - AREQUIPA, CARGA GENERAL')
            ->setValorReferencial(1200.0)
            ->setValorReferencialCargaEfectiva(1000.0)
            ->setValorReferencialCargaUtil(1100.0)
            ->setTramos([(new TramoTransporte())
                ->setId('1')
                ->setUbigeoOrigen('150101')
                ->setUbigeoDestino('040101')
                ->setDescripcion('LIMA - AREQUIPA POR LA PANAMERICANA SUR')
                ->setValorCargaEfectiva(950.0)
                ->setValorCargaUtilNominal(1050.0)
                ->setVehiculos([(new VehiculoTransporte())
                    ->setConfiguracion('T3S3')
                    ->setCargaUtil(30.0)
                    ->setCargaEfectiva(28.5)
                    ->setValorReferencialTm(40.0)
                    ->setRetornoVacio(false)])]));

        $xml = $this->build($invoice);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $linea = '/*/cac:InvoiceLine[1]/cac:Delivery';
        $valor = fn (string $ruta) => $xpath->evaluate('string('.$linea.$ruta.')');

        $this->assertSame('150101', $valor('/cac:Despatch/cac:DespatchAddress/cbc:ID'));
        $this->assertSame('AV. ARGENTINA 2450, LIMA', $valor('/cac:Despatch/cac:DespatchAddress/cac:AddressLine/cbc:Line'));
        $this->assertSame('040101', $valor('/cac:DeliveryLocation/cac:Address/cbc:ID'));
        $this->assertSame('CALLE MERCADERES 120, AREQUIPA', $valor('/cac:DeliveryLocation/cac:Address/cac:AddressLine/cbc:Line'));
        $this->assertSame('LIMA - AREQUIPA, CARGA GENERAL', $valor('/cac:Despatch/cbc:Instructions'));
        $this->assertSame(['01' => '1200.00', '02' => '1000.00', '03' => '1100.00'], [
            '01' => $valor('/cac:DeliveryTerms[cbc:ID="01"]/cbc:Amount'),
            '02' => $valor('/cac:DeliveryTerms[cbc:ID="02"]/cbc:Amount'),
            '03' => $valor('/cac:DeliveryTerms[cbc:ID="03"]/cbc:Amount'),
        ]);
        $tramo = '/cac:Shipment/cac:Consignment';
        $this->assertSame('01', $valor('/cac:Shipment/cbc:ID'));
        $this->assertSame(['1', '150101', '040101', 'LIMA - AREQUIPA POR LA PANAMERICANA SUR', '950.00', '1050.00'], [
            $valor($tramo.'/cbc:ID'),
            $valor($tramo.'/cac:PlannedPickupTransportEvent/cac:Location/cbc:ID'),
            $valor($tramo.'/cac:PlannedDeliveryTransportEvent/cac:Location/cbc:ID'),
            $valor($tramo.'/cbc:CarrierServiceInstructions'),
            $valor($tramo.'/cac:DeliveryTerms/cbc:Amount'),
            $valor($tramo.'/cbc:DeclaredForCarriageValueAmount'),
        ]);
        $vehiculo = $tramo.'/cac:TransportHandlingUnit';
        $this->assertSame(['T3S3', 'false', '40.00', '30.00', '28.50', 'TNE'], [
            $valor($vehiculo.'/cac:TransportEquipment/cbc:SizeTypeCode'),
            $valor($vehiculo.'/cac:TransportEquipment/cbc:ReturnabilityIndicator'),
            $valor($vehiculo.'/cac:TransportEquipment/cac:Delivery/cac:DeliveryTerms/cbc:Amount'),
            $valor($vehiculo.'/cac:MeasurementDimension[cbc:AttributeID="01"]/cbc:Measure'),
            $valor($vehiculo.'/cac:MeasurementDimension[cbc:AttributeID="02"]/cbc:Measure'),
            $valor($vehiculo.'/cac:MeasurementDimension[cbc:AttributeID="02"]/cbc:Measure/@unitCode'),
        ]);
        // Antes de los impuestos y los cargos de la línea, como pide UBL 2.1.
        $this->assertSame(0, $xpath->query('/*/cac:InvoiceLine[1]/cac:TaxTotal/following-sibling::cac:Delivery')->length);
        $this->assertSchema($xml);
    }

    public function testSinTransporteDeCargaNoSeEscribe()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');

        $doc = new \DOMDocument();
        $doc->loadXML($this->build($invoice));
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $this->assertSame(0, $xpath->query('/*/cac:InvoiceLine/cac:Delivery')->length);
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
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 05/10/2017
 * Time: 08:23
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Sale\Invoice;
use Greenter\Xml\Parser\InvoiceParser;
use PHPUnit\Framework\TestCase;

class InvoiceParserTest extends TestCase
{
    /**
     * @dataProvider providerSolDocs
     * @param string $filename
     */
    public function testParseSunatSOL($filename)
    {
        $parser = new InvoiceParser();

        $xml = file_get_contents($filename);
        /**@var $obj Invoice */
        $obj = $parser->parse($xml);

        $this->assertMatchesRegularExpression('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertMatchesRegularExpression('/^E\w{3}/', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getFechaEmision());
        $this->assertGreaterThanOrEqual(1, count($obj->getDetails()));
        $this->assertGreaterThanOrEqual(1, count($obj->getLegends()));
        $this->assertNotNull($obj->getCompany());
        $this->assertNotNull($obj->getCompany()->getAddress());
        $this->assertNotEmpty($obj->getCompany()->getAddress()->getDireccion());
        $this->assertNotEmpty($obj->getCompany()->getAddress()->getUbigueo());
    }

    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testFacParse($filename)
    {
        $parser = new InvoiceParser();

        $xml = file_get_contents($filename);
        /**@var $obj Invoice */
        $obj = $parser->parse($xml);

        $this->assertMatchesRegularExpression('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertMatchesRegularExpression('/^[FB]\w{3}/', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getFechaEmision());
        $this->assertGreaterThanOrEqual(1, count($obj->getDetails()));
        $this->assertGreaterThanOrEqual(1, count($obj->getLegends()));
        $this->assertTrue(is_float($obj->getMtoImpVenta()));
    }

    public function testFacParseFromDoc()
    {
        $parser = new InvoiceParser();

        $xml = file_get_contents($this->providerDocs()[0][0]);
        $doc = new \DOMDocument();
        @$doc->loadXML($xml);
        /**@var $obj Invoice */
        $obj = $parser->parse($doc);

        $this->assertMatchesRegularExpression('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertMatchesRegularExpression('/^[FB]\w{3}/', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getFechaEmision());
        $this->assertGreaterThanOrEqual(1, count($obj->getDetails()));
        $this->assertGreaterThanOrEqual(1, count($obj->getLegends()));
    }

    /**
     * Incoterm (cac:DeliveryTerms/cbc:ID): campo 62 de Factura2_0, condicional.
     */
    public function testParseIncoterm()
    {
        $parser = new InvoiceParser();
        $dir = __DIR__.'/../../Resources/invoice/';

        /**@var $withIncoterm Invoice */
        $withIncoterm = $parser->parse(file_get_contents($dir.'exportacion-incoterm.xml'));
        $this->assertSame('FOB', $withIncoterm->getIncoterm());

        /**@var $without Invoice */
        $without = $parser->parse(file_get_contents($dir.'exportacion.xml'));
        $this->assertNull($without->getIncoterm());
    }

    public function testParseTransporteCarga()
    {
        $parser = new InvoiceParser();
        $dir = __DIR__.'/../../Resources/invoice/';

        /**@var $invoice Invoice */
        $invoice = $parser->parse(file_get_contents($dir.'detraccion-transporte-carga.xml'));
        $transporte = $invoice->getDetails()[0]->getTransporteCarga();
        $this->assertNotNull($transporte);
        $this->assertSame(['150101', 'AV. ARGENTINA 2450, LIMA', '040101', 'CALLE MERCADERES 120, AREQUIPA', 'LIMA - AREQUIPA, CARGA GENERAL'], [
            $transporte->getOrigen()->getUbigueo(), $transporte->getOrigen()->getDireccion(),
            $transporte->getDestino()->getUbigueo(), $transporte->getDestino()->getDireccion(), $transporte->getDetalleViaje(),
        ]);
        $this->assertSame([1200.0, 1000.0, 1100.0], [$transporte->getValorReferencial(),
            $transporte->getValorCargaEfectiva(), $transporte->getValorCargaUtil()]);
        $tramo = $transporte->getTramos()[0];
        $this->assertSame(['1', '150101', '040101', 'LIMA - AREQUIPA POR LA PANAMERICANA SUR', 950.0, 1050.0], [$tramo->getId(),
            $tramo->getUbigeoOrigen(), $tramo->getUbigeoDestino(), $tramo->getDescripcion(), $tramo->getValorCargaEfectiva(),
            $tramo->getValorCargaNominal()]);
        $vehiculo = $tramo->getVehiculos()[0];
        $this->assertSame(['T3S3', 30.0, 28.5, 40.0, false], [$vehiculo->getConfiguracion(), $vehiculo->getCargaUtil(),
            $vehiculo->getCargaEfectiva(), $vehiculo->getValorReferencialTm(), $vehiculo->isRetornoVacio()]);

        /**@var $without Invoice */
        $without = $parser->parse(file_get_contents($dir.'detraccion.xml'));
        $this->assertNull($without->getDetails()[0]->getTransporteCarga());
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/invoice/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    public function providerSolDocs()
    {
        $files = glob(__DIR__.'/../../Resources/clavesol/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }
}

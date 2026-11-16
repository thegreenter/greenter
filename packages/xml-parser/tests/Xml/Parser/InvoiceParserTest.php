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

    public function testParseContrato()
    {
        $parser = new InvoiceParser();
        $dir = __DIR__.'/../../Resources/invoice/';

        /**@var $obj Invoice */
        $obj = $parser->parse(file_get_contents($dir.'gravada-contrato.xml'));
        $contrato = $obj->getContrato();
        $this->assertNotNull($contrato);
        $this->assertSame(['CCE-2026-014', '1', 'CONSORCIO VIAL DEL SUR', 35.5],
            [$contrato->getNumero(), $contrato->getTipo(), $contrato->getDescripcion(), $contrato->getPorcentaje()]);
        $participante = $obj->getParticipantes()[0];
        $this->assertSame(['6', '20601234567', 'CONSTRUCTORA ANDINA S.A.C.'],
            [$participante->getTipoDoc(), $participante->getNumDoc(), $participante->getRznSocial()]);

        /**@var $without Invoice */
        $without = $parser->parse(file_get_contents($dir.'gravada.xml'));
        $this->assertNull($without->getContrato());
        $this->assertNull($without->getParticipantes());
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

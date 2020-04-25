<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 05/10/2017
 * Time: 08:23
 */

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Sale\Invoice;
use Greenter\Xml\Parser\InvoiceParser;

class InvoiceParserTest extends \PHPUnit_Framework_TestCase
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

        $this->assertRegExp('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertRegExp('/^E\w{3}/', $obj->getSerie());
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

        $this->assertRegExp('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertRegExp('/^[FB]\w{3}/', $obj->getSerie());
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

        $this->assertRegExp('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertRegExp('/^[FB]\w{3}/', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getFechaEmision());
        $this->assertGreaterThanOrEqual(1, count($obj->getDetails()));
        $this->assertGreaterThanOrEqual(1, count($obj->getLegends()));
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

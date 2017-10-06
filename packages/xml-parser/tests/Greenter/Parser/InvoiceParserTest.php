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
     * @dataProvider filenameSolProvider
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
    }

    /**
     * @dataProvider filenameProvider
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
    }

    public function testFacParseFromDoc()
    {
        $parser = new InvoiceParser();

        $xml = file_get_contents($this->filenameProvider()[0][0]);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        /**@var $obj Invoice */
        $obj = $parser->parse($doc);

        $this->assertRegExp('/^0\d{1}/', $obj->getTipoDoc());
        $this->assertRegExp('/^[FB]\w{3}/', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getFechaEmision());
        $this->assertGreaterThanOrEqual(1, count($obj->getDetails()));
        $this->assertGreaterThanOrEqual(1, count($obj->getLegends()));
    }

    public function filenameProvider()
    {
        $dir = __DIR__.'/../../Resources/';
        return [
          [$dir.'invoice-full.xml'],
          [$dir.'anticipos.xml'],
          [$dir.'anticipos-regularizacion.xml'],
          [$dir.'boleta-itinerante.xml'],
          [$dir.'datos-no-trib.xml'],
          [$dir.'detraccion.xml'],
          [$dir.'exportacion.xml'],
          [$dir.'factura-guia.xml'],
          [$dir.'gravada.xml'],
        ];
    }

    public function filenameSolProvider()
    {
        $dir = __DIR__.'/../../Resources/';
        return [
            [$dir.'FACTURAE001-17.XML'],
            [$dir.'FACTURAE001-174.XML'],
        ];
    }
}

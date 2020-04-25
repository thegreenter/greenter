<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/10/2017
 * Time: 07:10 PM
 */

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Sale\Receipt;
use Greenter\Xml\Parser\ReceiptParser;
use PHPUnit\Framework\TestCase;

class ReceiptParserTest extends TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $doc Receipt */
        $doc = $this->getParser()->parse($xml);

        $this->assertStringStartsWith('E', $doc->getSerie());
        $this->assertLessThanOrEqual(8, strlen($doc->getCorrelativo()));
        $this->assertEquals(11, strlen($doc->getReceptor()->getNumDoc()));
        $this->assertNotEmpty($doc->getMontoLetras());
        $this->assertNotEmpty($doc->getConcepto());
        $this->assertNotEmpty($doc->getSubTotal());
        $this->assertNotEmpty($doc->getTotal());
        $this->assertNotEmpty($doc->getPorcentaje());
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/rrhh/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new ReceiptParser();
    }
}
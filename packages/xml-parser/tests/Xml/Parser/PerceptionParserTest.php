<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/01/2018
 * Time: 02:22 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Perception\Perception;
use Greenter\Xml\Parser\PerceptionParser;
use PHPUnit\Framework\TestCase;

class PerceptionParserTest extends TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $obj Perception */
        $obj = $this->getParser()->parse($xml);

        $this->assertMatchesRegularExpression('/^[P][0-9A-Z]{3}$/', $obj->getSerie());
        $this->assertMatchesRegularExpression('/^\d+$/', $obj->getCorrelativo());
        $this->assertNotNull($obj->getCompany());
        $this->assertNotNull($obj->getProveedor());
        $this->assertGreaterThan(0, count($obj->getDetails()));

        foreach ($obj->getDetails() as $detail) {
            $this->assertNotEmpty($detail->getTipoDoc());
            $this->assertNotEmpty($detail->getNumDoc());
            $this->assertNotNull($detail->getFechaEmision());
            $this->assertGreaterThan(0, count($detail->getCobros()));
            $this->assertTrue(is_float($detail->getImpTotal()));
            $this->assertTrue(is_float($detail->getImpPercibido()));
            $this->assertTrue(is_float($detail->getImpCobrar()));
        }
    }

    /**
     * Field 7 of SUNAT's "Percepciones1_0" sheet, and conditional: absent
     * from a document that is not exceptionally issued.
     */
    public function testParseIndExcepcional()
    {
        $withIndicator = $this->parseResource('20000000001-40-P001-2.xml');
        $this->assertSame('01', $withIndicator->getIndExcepcional());

        $without = $this->parseResource('20000000001-40-P001-1.xml');
        $this->assertNull($without->getIndExcepcional());
    }

    private function parseResource(string $filename): Perception
    {
        $path = __DIR__.'/../../Resources/perception/'.$filename;

        /**@var $obj Perception */
        $obj = $this->getParser()->parse(file_get_contents($path));

        return $obj;
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/perception/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new PerceptionParser();
    }
}
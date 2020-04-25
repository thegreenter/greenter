<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/01/2018
 * Time: 02:22 PM
 */

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Perception\Perception;
use Greenter\Xml\Parser\PerceptionParser;

class PerceptionParserTest extends \PHPUnit_Framework_TestCase
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

        $this->assertRegExp('/^[P][0-9A-Z]{3}$/', $obj->getSerie());
        $this->assertRegExp('/^\d+$/', $obj->getCorrelativo());
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
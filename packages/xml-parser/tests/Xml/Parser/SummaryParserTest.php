<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/01/2018
 * Time: 12:21 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Summary\Summary;
use Greenter\Xml\Parser\SummaryParser;
use PHPUnit\Framework\TestCase;

class SummaryParserTest extends TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $obj Summary */
        $obj = $this->getParser()->parse($xml);

        $this->assertStringContainsString('RC', $obj->getName());
        $this->assertRegExp('/^\d+$/', $obj->getCorrelativo());
        $this->assertNotNull($obj->getCompany());
        $this->assertGreaterThan(0, count($obj->getDetails()));

        foreach ($obj->getDetails() as $detail) {
            $this->assertTrue(in_array($detail->getTipoDoc(), ['03', '07', '08']));
            $this->assertTrue(in_array($detail->getEstado(), ['1', '2', '3']));
            $this->assertRegExp('/^B\d{3}-\d{1,8}$/', $detail->getSerieNro());
            $this->assertTrue(is_float($detail->getTotal()));
            if ($detail->getDocReferencia()) {
                $ref = $detail->getDocReferencia();
                $this->assertNotEmpty($ref->getNroDoc());
                $this->assertTrue(in_array($ref->getTipoDoc(), ['03', '12']));
            }

            if ($detail->getPercepcion()) {
                $perc = $detail->getPercepcion();
                $this->assertNotEmpty($perc->getCodReg());
                $this->assertTrue(is_float($perc->getTasa()));
                $this->assertTrue(is_float($perc->getMto()));
                $this->assertTrue(is_float($perc->getMtoBase()));
                $this->assertTrue(is_float($perc->getMtoTotal()));
            }
        }
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/resumen/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new SummaryParser();
    }

}
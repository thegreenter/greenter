<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 08/11/2017
 * Time: 21:44
 */

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Parser\VoidedParser;

class VoidedParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $doc Voided */
        $doc = $this->getParser()->parse($xml);

        $this->assertLessThanOrEqual(5, strlen($doc->getCorrelativo()));
        $this->assertLessThanOrEqual(new \DateTime(), $doc->getFecComunicacion());
        $this->assertLessThanOrEqual(new \DateTime(), $doc->getFecGeneracion());
        $this->assertGreaterThanOrEqual(1, count($doc->getDetails()));
    }

    public function testParseDocReversion()
    {
        $xml = file_get_contents(__DIR__.'/../../Resources/bajas/20480072872-RR-20171002-00001.xml');
        /**@var $doc Voided */
        $doc = $this->getParser()->parse($xml);

        $this->assertInstanceOf(Reversion::class, $doc);
    }

    public function testParseDocBaja()
    {
        $xml = file_get_contents(__DIR__.'/../../Resources/bajas/20338570041-RA-20170628-0008.xml');
        /**@var $doc Voided */
        $doc = $this->getParser()->parse($xml);

        $this->assertInstanceOf(Voided::class, $doc);
        $this->assertNotInstanceOf(Reversion::class, $doc);
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/bajas/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new VoidedParser();
    }
}
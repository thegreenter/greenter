<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 06/11/2017
 * Time: 10:41 AM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Despatch\Despatch;
use Greenter\Xml\Parser\DespatchParser;
use PHPUnit\Framework\TestCase;

/**
 * Class DespatchParserTest
 * @package Tests\Greenter\Xml\Parser
 */
class DespatchParserTest extends TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $obj Despatch */
        $obj = $this->getParser()->parse($xml);

        $this->assertEquals('09', $obj->getTipoDoc());
        $this->assertMatchesRegularExpression('/^T\w{3}/', $obj->getSerie());
        $this->assertNotNull($obj->getCompany());
        $this->assertNotNull($obj->getDestinatario());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertGreaterThan(0, count($obj->getDetails()));
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/guias/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new DespatchParser();
    }
}
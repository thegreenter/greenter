<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 29/01/2018
 * Time: 03:42 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Retention\Retention;
use Greenter\Xml\Parser\RetentionParser;
use PHPUnit\Framework\TestCase;

class RetentionParserTest extends TestCase
{
    /**
     * @dataProvider providerDocs
     * @param string $filename
     */
    public function testParseDoc($filename)
    {
        $xml = file_get_contents($filename);
        /**@var $obj Retention */
        $obj = $this->getParser()->parse($xml);

        $this->assertMatchesRegularExpression('/^[R][0-9A-Z]{3}$/', $obj->getSerie());
        $this->assertMatchesRegularExpression('/^\d+$/', $obj->getCorrelativo());
        $this->assertNotNull($obj->getCompany());
        $this->assertNotNull($obj->getProveedor());
        $this->assertGreaterThan(0, count($obj->getDetails()));

        foreach ($obj->getDetails() as $detail) {
            $this->assertNotEmpty($detail->getTipoDoc());
            $this->assertNotEmpty($detail->getNumDoc());
            $this->assertNotNull($detail->getFechaEmision());
            $this->assertTrue(is_array($detail->getPagos()));
            $this->assertTrue(is_float($detail->getImpTotal()));
            $this->assertTrue(is_float($detail->getImpRetenido()));
            $this->assertTrue(is_float($detail->getImpPagar()));
        }
    }

    public function providerDocs()
    {
        $files = glob(__DIR__.'/../../Resources/retention/*.xml');

        return array_map(function ($file) {
            return [$file];
        }, $files);
    }

    private function getParser()
    {
        return new RetentionParser();
    }
}
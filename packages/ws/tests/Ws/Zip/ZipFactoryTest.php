<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48
 */

namespace Tests\Greenter\Zip;

use Greenter\Zip\ZipFly;

/**
 * Class ZipFactoryTest
 * @package Tests\Greenter\Zip\ZipFactory
 */
class ZipFactoryTest extends \PHPUnit_Framework_TestCase
{
    const DATA_XML = '<root>Empty</root>';

    public function testCompressFile()
    {
        $zip = $this->createZip();

        $this->assertNotEmpty($zip);
    }

    public function testMultipleCompress()
    {
        $txtContent = '<h1>GREENTER WS</h1>';
        $helper = new ZipFly();
        $zip = $helper->compress('myFile.xml', self::DATA_XML);
        $zip2 = $helper->compress('myFile.xml', $txtContent);

        $result1 = $helper->decompressXmlFile($zip);
        $result2 = $helper->decompressXmlFile($zip2);

        $this->assertEquals(self::DATA_XML, $result1);
        $this->assertEquals($txtContent, $result2);
    }

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFly();
        $content = $helper->decompressXmlFile($zipContent);

        $this->assertEquals(self::DATA_XML, $content);
    }

    public function testUnixTime()
    {
        $zip = new ZipFly();
        $result = $zip->unix2DosTime(181233012);

        $this->assertEquals(2162688, $result);
    }

    public function testInvalidZip()
    {
        $zip = new ZipFly();
        $res = $zip->decompressXmlFile('');

        $this->assertEmpty($res);
    }

    public function testNotXmlZip()
    {
        $helper = new ZipFly();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        $res = (new ZipFly())->decompressXmlFile($zip);

        $this->assertEmpty($res);
    }

    private function createZip()
    {
        $helper = new ZipFly();
        $zip = $helper->compress('myFile.xml', self::DATA_XML);

        return $zip;
    }
}

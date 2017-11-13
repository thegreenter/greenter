<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48
 */

namespace Tests\Greenter\Zip;

use Greenter\Zip\ZipFactory;
use Greenter\Zip\ZipFile;

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

    public function testDecompressFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFactory();
        $content = $helper->decompress($zipContent, 'myFile.xml');

        $this->assertEquals(self::DATA_XML, $content);
    }

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFactory();
        $content = $helper->decompressXmlFile($zipContent);

        $this->assertEquals(self::DATA_XML, $content);
    }

    public function testUnixTime()
    {
        $zip = new ZipFile();
        $result = $zip->unix2DosTime(181233012);

        $this->assertEquals(2162688, $result);
    }

    public function testInvalidZip()
    {
        $zip = new ZipFactory();
        $res = $zip->decompressXmlFile('');

        $this->assertEmpty($res);
    }

    public function testNotXmlZip()
    {
        $helper = new ZipFactory();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        $res = $helper->decompressXmlFile($zip);

        $this->assertEmpty($res);
    }

    private function createZip()
    {
        $helper = new ZipFactory();
        $zip = $helper->compress('myFile.xml', self::DATA_XML);

        return $zip;
    }
}

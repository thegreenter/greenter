<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48
 */

namespace Tests\Greenter\Zip;

use Greenter\Zip\ZipReader;
use Greenter\Zip\ZipWriter;

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

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipReader();
        $content = $helper->decompressXmlFile($zipContent);

        $this->assertEquals(self::DATA_XML, $content);
    }

    public function testUnixTime()
    {
        $zip = new ZipWriter();
        $result = $zip->unix2DosTime(181233012);

        $this->assertEquals(2162688, $result);
    }

    public function testInvalidZip()
    {
        $zip = new ZipReader();
        $res = $zip->decompressXmlFile('');

        $this->assertEmpty($res);
    }

    public function testNotXmlZip()
    {
        $helper = new ZipWriter();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        $res = (new ZipReader())->decompressXmlFile($zip);

        $this->assertEmpty($res);
    }

    private function createZip()
    {
        $helper = new ZipWriter();
        $zip = $helper->compress('myFile.xml', self::DATA_XML);

        return $zip;
    }
}

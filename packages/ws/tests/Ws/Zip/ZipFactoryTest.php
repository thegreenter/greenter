<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48.
 */

namespace Tests\Greenter\Zip;

use Greenter\Zip\ZipFly;

/**
 * Class ZipFactoryTest.
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

        $result1 = $this->getXmlResponse($helper, $zip);
        $result2 = $this->getXmlResponse($helper, $zip2);

        $this->assertEquals(self::DATA_XML, $result1);
        $this->assertEquals($txtContent, $result2);
    }

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFly();
        $content = $this->getXmlResponse($helper, $zipContent);

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
        $res = $zip->decompress('');

        $this->assertEmpty($res);
    }

    public function testNotXmlZip()
    {
        $helper = new ZipFly();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        $res = $this->getXmlResponse(new ZipFly(), $zip);

        $this->assertEmpty($res);
    }

    private function createZip()
    {
        $helper = new ZipFly();
        $zip = $helper->compress('myFile.xml', self::DATA_XML);

        return $zip;
    }

    private function getXmlResponse(ZipFly $zipper, $content)
    {
        $filter = function ($filename) {
            return 'xml' === strtolower($this->getFileExtension($filename));
        };
        $files = $zipper->decompress($content, $filter);

        return 0 === count($files) ? '' : $files[0]['content'];
    }

    private function getFileExtension($filename)
    {
        $lastDotPos = strrpos($filename, '.');
        if (!$lastDotPos) {
            return '';
        }

        return substr($filename, $lastDotPos + 1);
    }
}

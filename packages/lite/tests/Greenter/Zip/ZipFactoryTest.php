<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48
 */

namespace Tests\Greenter\Zip;

use Greenter\Zip\ZipFactory;

/**
 * Class ZipFactoryTest
 * @package Tests\Greenter\Zip\ZipFactory
 */
class ZipFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCompressFile()
    {
        $zip = $this->createZip();

        //file_put_contents(sys_get_temp_dir() . '/myzip.zip', $zip);
        $this->assertNotEmpty($zip);
    }

    public function testDecompressFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFactory();
        $content = $helper->decompress($zipContent, 'myFile.txt');

        $this->assertEquals('TEST TEXT 1', $content);
    }

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipFactory();
        $content = $helper->decompressLastFile($zipContent);

        $this->assertEquals('TEST TEXT 1', $content);
    }

    private function createZip()
    {
        $helper = new ZipFactory();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        return $zip;
    }
}

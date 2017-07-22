<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:48
 */

namespace Tests\Greenter\Helper;

use Greenter\Helper\ZipHelper;

/**
 * Class ZipHelperTest
 * @package Tests\Greenter\Helper\ZipHelper
 */
class ZipHelperTest extends \PHPUnit_Framework_TestCase
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
        $helper = new ZipHelper();
        $content = $helper->decompress($zipContent, 'myFile.txt');

        $this->assertEquals('TEST TEXT 1', $content);
    }

    public function testDecompressLastFile()
    {
        $zipContent = $this->createZip();
        $helper = new ZipHelper();
        $content = $helper->decompressLastFile($zipContent);

        $this->assertEquals('TEST TEXT 1', $content);
    }

    private function createZip()
    {
        $helper = new ZipHelper();
        $zip = $helper->compress('myFile.txt', 'TEST TEXT 1');

        return $zip;
    }
}

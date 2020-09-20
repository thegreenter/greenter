<?php
/**
 * Created by PhpStorm.
 * User: LPALQUILER-11
 * Date: 29/08/2018
 * Time: 17:41.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Zip;

use Greenter\Zip\DecompressInterface;
use Greenter\Zip\ZipDecompressDecorator;
use Greenter\Zip\ZipFly;
use PHPUnit\Framework\TestCase;

/**
 * Class ZipFileDecompressTest.
 */
class ZipFileDecompressTest extends TestCase
{
    /**
     * @var DecompressInterface
     */
    private $zip;

    protected function setUp(): void
    {
        $this->zip = new ZipDecompressDecorator(new ZipFly());
    }

    public function testDecompressEmptyFile()
    {
        $items = $this->zip->decompress('');

        $this->assertEquals(0, count($items));
    }

    public function testDecompressInvalidZipFile()
    {
        $items = $this->zip->decompress('xxx');

        $this->assertEquals(0, count($items));
    }

    public function testDecompressWithoutFilter()
    {
        $content = $this->createZipWithPlainFile('my.txt');
        $items = $this->zip->decompress($content);

        $this->assertEquals(1, count($items));
    }

    public function testDecompressWithFilterNotFound()
    {
        $content = $this->createZipWithPlainFile('my.txt');
        $items = $this->zip->decompress($content, function ($filename) {
            return strpos($filename, 'xml');
        });

        $this->assertEquals(0, count($items));
    }

    public function testDecompressWithFilterFound()
    {
        $content = $this->createZipWithPlainFile('my.xml');
        $items = $this->zip->decompress($content, function ($filename) {
            return strpos($filename, 'xml');
        });

        $this->assertEquals(1, count($items));
    }

    private function createZipWithPlainFile($name)
    {
        $helper = new ZipFly();
        $zip = $helper->compress($name, '--');

        return $zip;
    }
}

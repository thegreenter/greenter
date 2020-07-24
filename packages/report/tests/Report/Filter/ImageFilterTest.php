<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/01/2018
 * Time: 10:31 AM
 */

declare(strict_types=1);

namespace Tests\Greenter\Report\Filter;

use Greenter\Report\Filter\ImageFilter;
use PHPUnit\Framework\TestCase;

/**
 * Class ImageFilterTest
 */
class ImageFilterTest extends TestCase
{
    /**
     * @var ImageFilter
     */
    private $filter;

    protected function setUp(): void
    {
        $this->filter = new ImageFilter();
    }

    public function testMimeTypeIsPng()
    {
        $image = file_get_contents(__DIR__.'/../../Resources/logo.png');

        $mime = $this->filter->getMimeType($image);

        $this->assertEquals('png', $mime);
    }

    public function testMimeTypeIsJpeg()
    {
        $image = file_get_contents(__DIR__.'/../../Resources/ciscologo.jpg');

        $mime = $this->filter->getMimeType($image);

        $this->assertEquals('jpeg', $mime);
    }

    public function testMimeTypeIsNotJpegFromPng()
    {
        $image = file_get_contents(__DIR__.'/../../Resources/logo.png');

        $mime = $this->filter->getMimeType($image);

        $this->assertNotEquals('jpeg', $mime);
    }

    public function testMimeTypeIsNotJpegFromGif()
    {
        $image = file_get_contents(__DIR__.'/../../Resources/image.gif');

        $mime = $this->filter->getMimeType($image);

        $this->assertNotEquals('jpeg', $mime);
    }


    public function testMimeTypeIsGif()
    {
        $image = file_get_contents(__DIR__.'/../../Resources/image.gif');

        $mime = $this->filter->getMimeType($image);

        $this->assertEquals('gif', $mime);
    }
}
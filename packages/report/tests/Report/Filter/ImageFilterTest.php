<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/01/2018
 * Time: 10:31 AM
 */

namespace Tests\Greenter\Report\Filter;

use Greenter\Report\Filter\ImageFilter;

/**
 * Class ImageFilterTest
 */
class ImageFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ImageFilter
     */
    private $filter;

    protected function setUp()
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
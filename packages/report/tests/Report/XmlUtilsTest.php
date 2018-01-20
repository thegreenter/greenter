<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 04:45 PM.
 */

namespace Tests\Greenter\Report;

use Greenter\Report\XmlUtils;

/**
 * Class XmlUtilsTest.
 */
class XmlUtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlUtils
     */
    private $utils;

    protected function setUp()
    {
        $this->utils = new XmlUtils();
    }

    /**
     * @dataProvider xmlPathProvider
     *
     * @param string $filename
     */
    public function testExtractFromDoc($filename)
    {
        $doc = new \DOMDocument();
        $doc->load($filename);
        $hash = $this->utils->getHashSignFromDoc($doc);

        $this->assertNotEmpty($hash);
    }

    /**
     * @dataProvider xmlPathProvider
     *
     * @param string $filename
     */
    public function testExtractFromFile($filename)
    {
        $hash = $this->utils->getHashSignFromFile($filename);

        $this->assertNotEmpty($hash);
    }

    /**
     * @dataProvider xmlPathProvider
     *
     * @param string $filename
     */
    public function testExtract($filename)
    {
        $xml = file_get_contents($filename);
        $hash = $this->utils->getHashSign($xml);

        $this->assertNotEmpty($hash);
        echo basename($filename).' => '.$hash.PHP_EOL;
    }

    public function testExtractFromEmptyExt()
    {
        $hash = $this->utils->getHashSign('<h1>EMPTY</h1>');

        $this->assertEmpty($hash);
    }

    public function testExtractFromEmptyDs()
    {
        $hash = $this->utils->getHashSignFromFile(__DIR__.'/../Resources/EmptySign.xml');

        $this->assertEmpty($hash);
    }

    public function xmlPathProvider()
    {
        $dir = __DIR__.'/../Resources';

        return [
            [$dir.'/20505310072-01-F001-00019772.xml'],
            [$dir.'/20505310072-03-B001-00000088.xml'],
        ];
    }
}

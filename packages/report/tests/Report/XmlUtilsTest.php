<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 04:45 PM
 */

namespace Tests\Greenter\Report;

use Greenter\Report\XmlUtils;

/**
 * Class XmlUtilsTest
 * @package Tests\Greenter\Report
 */
class XmlUtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider xmlPathProvider
     * @param string $filename
     */
    public function testExtract($filename)
    {
        $xml = file_get_contents($filename);
        $hash = XmlUtils::extractSign($xml);

        $this->assertNotEmpty($hash);
        echo basename($filename) . ' => ' . $hash . PHP_EOL;
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
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM
 */

namespace tests\Greenter\Ws\Services;

use Greenter\Helper\ZipHelper;
use Greenter\Ws\Services\FeSunat;

/**
 * Class FeSunatTest
 * @package tests\Greenter\Ws\Services
 */
class FeSunatTest  extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $nameZip = '20600055519-01-F001-00000001.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $ws = new FeSunat('20600055519MODDATOS', 'moddatos');
        $ws->setService(FeSunat::BETA);
        $response = $ws->send($nameZip, $zip);
        $this->assertNotEmpty($response);
        $this->assertXmlResponse($response, 'R-20600055519-01-F001-00000001.xml');
    }

    private function assertXmlResponse($zipContent, $filename)
    {
        $helper = new ZipHelper();
        $content = $helper->decompress($zipContent, $filename);

        $this->assertContains('La Factura numero F001-00000001, ha sido aceptada', $content);
    }
}

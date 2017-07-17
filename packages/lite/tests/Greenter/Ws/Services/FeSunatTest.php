<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM
 */

namespace tests\Greenter\Ws\Services;

use Greenter\Ws\Services\FeSunat;

/**
 * Class FeSunatTest
 * @package tests\Greenter\Ws\Services
 */
class FeSunatTest  extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $nameZip = '20600995805-01-F001-1.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $ws = new FeSunat('20000000001MODDATOS', 'moddatos');
        $ws->setService(FeSunat::BETA);
//        $response = $ws->send($nameZip, $zip);
//        $this->assertNotEmpty($response);
//        echo $response;
    }
}
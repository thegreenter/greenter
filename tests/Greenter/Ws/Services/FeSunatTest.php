<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\FeSunat;

/**
 * Class FeSunatTest
 * @package tests\Greenter\Ws\Services
 */
class FeSunatTest  extends \PHPUnit_Framework_TestCase
{
    use FeSunatTrait;

    public function testSendInvoice()
    {
        $nameZip = '20600055519-01-F001-00000001.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $wss = $this->getSender();
        $response = $wss->send($nameZip, $zip);

        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getCdrResponse());
        $this->assertContains('La Factura numero F001-00000001, ha sido aceptada',
            $response->getCdrResponse()->getDescription());
    }

    public function testSendVoided()
    {
        $nameZip = '20600995805-RA-20170719-01.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $wss = $this->getSender();
        $ticket = $wss->sendSummary($nameZip, $zip);

        $this->assertEquals(13, strlen($ticket));
    }

    public function testGetStatus()
    {
        $wss = $this->getSender();
        $wss->setService(FeSunat::BETA);
        $code = $wss->getStatus('1500523236696');

        $this->assertNotEmpty($code);
        $code =  preg_replace('/[^0-9]+/', '', $code);
        $this->assertEquals(200, $code);
    }
}

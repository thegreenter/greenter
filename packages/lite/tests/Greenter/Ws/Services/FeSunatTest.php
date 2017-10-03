<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;

/**
 * Class FeSunatTest
 * @package Tests\Greenter\Ws\Services
 */
class FeSunatTest extends FeSunatTestBase
{
    public function testSendInvoice()
    {
        $nameZip = '20600055519-01-F001-00000001.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $wss = $this->getBillSender();
        $response = $wss->send($nameZip, $zip);

        /**@var $response BillResult */
        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getCdrResponse());
        $this->assertContains('La Factura numero F001-00000001, ha sido aceptada',
            $response->getCdrResponse()->getDescription());
    }

    public function testSendVoided()
    {
        $nameZip = '20600995805-RA-20170719-01.zip';
        $zip = file_get_contents(__DIR__."/../../Resources/$nameZip");

        $wss = $this->getSummarySender();
        $result = $wss->send($nameZip, $zip);

        /**@var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    public function testGetStatus()
    {
        $wss = $this->getStatusSender();
        $result = $wss->getStatus('1500523236696');

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCode());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }

    public function testGetCdrStatus()
    {
        $wss = $this->getStatusSender();
        $result = $wss->getCdrStatus('20000000001', '01', 'F001', '1');

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('0', $result->getCode());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }
}

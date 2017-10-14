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
        $nameXml = '20600055519-01-F001-00000001.xml';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml");

        $wss = $this->getBillSender();
        $response = $wss->send($nameXml, $xml);

        /**@var $response BillResult */
        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getCdrResponse());
        $this->assertContains('La Factura numero F001-00000001, ha sido aceptada',
            $response->getCdrResponse()->getDescription());
    }

    public function testSendVoided()
    {
        $nameXml = '20600995805-RA-20170719-01.xml';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml");

        $wss = $this->getSummarySender();
        $result = $wss->send($nameXml, $xml);

        /**@var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    public function testGetStatus()
    {
        $wss = $this->getExtSender();
        $result = $wss->getStatus('1500523236696');

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCode());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }

    public function testGetCdrStatus()
    {
        $wss = $this->getExtSender();
        $result = $wss->getCdrStatus('20000000001', '01', 'F001', '1');

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('0', $result->getCode());
        $this->assertNotEmpty($result->getMessage());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }

    public function testInvalidCdrStatus()
    {
        $wss = $this->getExtSunat();
        $result = $wss->getCdrStatus('20000000001', '01', 'F001', '1');

        $this->assertFalse($result->isSuccess());
    }

    /**
     * @dataProvider codeProvider
     * @param $code
     */
    public function testFaultError($code)
    {
        $sender = $this->getExtServiceForFault($code);
        $res = $sender->getStatus('23');

        $this->assertFalse($res->isSuccess());
    }

    public function codeProvider()
    {
        return [
          ['NO CODE'],
          ['111111111']
        ];
    }
}

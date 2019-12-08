<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM.
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;

/**
 * Class FeSunatTest.
 */
class FeSunatTest extends \PHPUnit_Framework_TestCase
{
    use FeSunatTestTrait;

    public function testSendInvoice()
    {
        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getBillSenderMock();
        $response = $wss->send($nameXml, $xml);

        /** @var $response BillResult */
        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getCdrResponse());
        $this->assertContains(
            'La Factura numero F001-00000001, ha sido aceptada',
            $response->getCdrResponse()->getDescription()
        );
    }

    /**
     * @group manual
     */
    public function testSendInvoiceBillSender()
    {
        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getBillSender();
        $response = $wss->send($nameXml, $xml);

        /** @var $response BillResult */
        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getCdrResponse());
        $this->assertContains(
            'La Factura numero F001-00000001, ha sido aceptada',
            $response->getCdrResponse()->getDescription()
        );
    }

    public function testSendInvalidInvoice()
    {
        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getBillSenderThrow('0156');
        $response = $wss->send($nameXml, $xml);

        /** @var $response BillResult */
        $this->assertFalse($response->isSuccess());
        $this->assertEquals('0156', $response->getError()->getCode());
        $this->assertEquals('El archivo ZIP esta corrupto', $response->getError()->getMessage());
    }

    public function testSendVoided()
    {
        $nameXml = '20600995805-RA-20170719-01';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getSummarySenderMock();
        $result = $wss->send($nameXml, $xml);

        /** @var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    public function testSendVoidedSummarySender()
    {
        $nameXml = '20600995805-RA-20170719-01';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getSummarySender();
        $result = $wss->send($nameXml, $xml);

        if (!$result->isSuccess()) {
            return;
        }

        /** @var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertTrue($result->isSuccess());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    public function testSendInvalidVoided()
    {
        $nameXml = '20600995805-RA-20170719-01';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getSummarySenderThrow('2001');
        $result = $wss->send($nameXml, $xml);

        /** @var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertFalse($result->isSuccess());
        $this->assertEquals('2001', $result->getError()->getCode());
    }

    /**
     * @group manual
     */
    public function testSendSummaryV2()
    {
        $nameXml = '20000000001-RC-20171119-001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $wss = $this->getSummarySender();
        $result = $wss->send($nameXml, $xml);

        /** @var $result SummaryResult */
        $this->assertNotNull($result);
        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2335', $result->getError()->getCode());
    }

    public function testGetStatus()
    {
        $wss = $this->getExtServiceMock();
        $result = $wss->getStatus('1500523236696');

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCode());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }

    /**
     * @expectedException \Exception
     */
    public function testGetStatusInvalidResponse()
    {
        $wss = $this->getExtServiceMock();
        $wss->getStatus('1500523236600');
    }

    public function testGetStatusWithExceptionCode()
    {
        $wss = $this->getExtServiceMock();
        $result = $wss->getStatus('667123123214');

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrResponse());
        $this->assertGreaterThanOrEqual(100, intval($result->getCode()));
        $this->assertLessThanOrEqual(1999, intval($result->getCode()));
    }

    public function testGetStatusPending()
    {
        $service = $this->getExtServiceMock();

        $result = $service->getStatus('223123123213');

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrResponse());
        $this->assertNotNull($result->getError());
        $this->assertNotEmpty($result->getError()->getMessage());
    }

    /**
     * @dataProvider codeProvider
     *
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
          ['111111111'],
        ];
    }
}

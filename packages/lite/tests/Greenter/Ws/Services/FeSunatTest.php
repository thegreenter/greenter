<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 05:18 PM
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\SummaryResult;
use Greenter\Ws\Services\SenderInterface;

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

    public function testGetInvalidStatus()
    {
        $wss = $this->getSender();
        $result = $wss->getStatus('1500523236696');

        $this->assertNotNull($result);
        $this->assertFalse($result->isSuccess());
    }

    /**
     * @return SenderInterface
     */
    private function getBillSender()
    {
        $stub = $this->getMockBuilder(SenderInterface::class)
                    ->getMock();
        $stub->method('send')->will($this->returnValue((new BillResult())
            ->setCdrResponse((new CdrResponse())
                ->setCode('0')
                ->setDescription('La Factura numero F001-00000001, ha sido aceptada')
                ->setId('F001-00000001'))
            ->setSuccess(true)
        ));

        /**@var $stub SenderInterface*/
        return $stub;
    }

    /**
     * @return SenderInterface
     */
    private function getSummarySender()
    {
        $stub = $this->getMockBuilder(SenderInterface::class)
                        ->getMock();
        $stub->method('send')->will($this->returnValue((new SummaryResult())
            ->setTicket('1500523236696')
            ->setSuccess(true)
        ));

        /**@var $stub SenderInterface*/
        return $stub;
    }
}

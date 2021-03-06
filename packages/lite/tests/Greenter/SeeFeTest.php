<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/10/2017
 * Time: 04:59 PM
 */

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Invoice;
use Greenter\See;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\SunatEndpoints;
use Tests\Greenter\Factory\FeFactoryBase;

/**
 * Class SeeFeTest
 * @group integration
 */
class SeeFeTest extends FeFactoryBase
{
    /**
     * @dataProvider providerInvoiceDocsv21
     * @param DocumentInterface $doc
     */
    public function testSendInvoiceV21(DocumentInterface $doc)
    {
        /**@var $result BillResult*/
        $see = $this->getSee();
        $this->assertNotNull($see->getFactory());

        $result = $see->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCdrResponse()->getCode());
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    /**
     * @return string
     */
    public function testSendSummary()
    {
        $doc = $this->getSummary();
        $result = $this->getSee()->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
    }

    /**
     * @depends testSendSummary
     * @param $ticket
     */
    public function testGetStatus($ticket)
    {
        $result = $this->getSee()->getStatus($ticket);

        if ($result->getCode() !== '0') {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue($result->isSuccess());
        $this->assertNull($result->getError());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCdrResponse()->getCode());
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    /**
     * @dataProvider providerInvoiceDocsV21
     * @param DocumentInterface $doc
     */
    public function testGetXmlSigned(DocumentInterface $doc)
    {
        $xmlSigned = $this->getSee()->getXmlSigned($doc);

        $this->assertNotEmpty($xmlSigned);
    }

    public function testSendXml()
    {
        $see = $this->getSee();
        $invoice = $this->getInvoice();
        $xmlSigned = $see->getXmlSigned($invoice);

        $this->assertNotEmpty($xmlSigned);

        $result = $see->sendXml(Invoice::class, $invoice->getName(), $xmlSigned);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCdrResponse()->getCode());
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    /**
     * @throws \Exception
     */
    public function testSendXmlFile()
    {
        $see = $this->getSee();
        $invoice = $this->getInvoice();
        $xmlSigned = $see->getXmlSigned($invoice);

        $result = $see->sendXmlFile($xmlSigned);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCdrResponse()->getCode());
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    public function providerInvoiceDocsV21()
    {
        return [
            [$this->getInvoice()],
            [$this->getCreditNote()],
            [$this->getDebitNote()],
        ];
    }

    private function getSee()
    {
        $endpoint = SunatEndpoints::FE_BETA;
        $see = new See();
        $see->setService($endpoint);
        $see->setBuilderOptions([
            'strict_variables' => true,
            'optimizations' => 0,
            'debug' => true,
        ]);
        $see->setCachePath(null);
        $see->setCodeProvider($this->getErrorCodeProvider());
        $see->setClaveSOL('20123456789', 'MODDATOS', 'moddatos');
        $see->setCertificate(file_get_contents(__DIR__.'/../Resources/SFSCert.pem'));

        return $see;
    }

    private function getErrorCodeProvider()
    {
        $stub = $this->getMockBuilder(ErrorCodeProviderInterface::class)
            ->getMock();

        $stub->method('getValue')
            ->willReturn('');

        /**@var $stub ErrorCodeProviderInterface */
        return $stub;
    }
}

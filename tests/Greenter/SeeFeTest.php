<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/10/2017
 * Time: 04:59 PM
 */

namespace Tests\Greenter;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\BaseSale;
use Greenter\Model\Sale\Invoice;
use Greenter\See;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\SunatEndpoints;
use Tests\Greenter\Factory\FeFactoryBase;

/**
 * Class SeeFeTest
 * @package Greenter
 */
class SeeFeTest extends FeFactoryBase
{
    /**
     * @dataProvider providerInvoiceDocs
     * @param DocumentInterface $doc
     */
    public function testSendInvoice(DocumentInterface $doc)
    {
        /**@var $result BillResult*/
        $see = $this->getSee();
        $this->assertNotNull($see->getFactory());

        $result = $see->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains(
            'aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @dataProvider providerSummaryDocs
     * @param DocumentInterface $doc
     * @return string
     */
    public function testSendSummary(DocumentInterface $doc)
    {
        /**@var $result SummaryResult*/
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

        if ($result->getCode() === '0127')
        {
            return;
        }

        $this->assertTrue($result->isSuccess());
        $this->assertNull($result->getError());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals('0', $result->getCdrResponse()->getCode());
        $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
    }

    /**
     * @dataProvider providerInvoiceDocs
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
    }

    /**
     * @dataProvider providerInvoiceDocsv21
     * @param DocumentInterface $doc
     */
    public function testSendInvoiceV21(DocumentInterface $doc)
    {
        /**@var $doc BaseSale */
        $doc->setUblVersion('2.1');
        /**@var $result BillResult*/
        $see = $this->getSee();
        $this->assertNotNull($see->getFactory());

        $result = $see->send($doc);
//        file_put_contents($doc->getName().'.xml', $see->getFactory()->getLastXml());

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains(
            'aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function providerInvoiceDocsV21()
    {
        return [
            [$this->getInvoiceV21()],
            [$this->getCreditNoteV21()],
            [$this->getDebitNoteV21()],
        ];
    }

    public function providerInvoiceDocs()
    {
        return [
            [$this->getInvoice()],
            [$this->getCreditNote()],
            [$this->getDebitNote()],
        ];
    }

    public function providerSummaryDocs()
    {
        return [
            [$this->getSummary()],
            [$this->getVoided()],
        ];
    }

    private function getSee()
    {
        $see = new See();
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setBuilderOptions([
            'strict_variables' => true,
            'optimizations' => 0,
            'debug' => true,
        ]);
        $see->setCachePath(false);
        $see->setCodeProvider($this->getErrorCodeProvider());
        $see->setCredentials('20000000001MODDATOS', 'moddatos');
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
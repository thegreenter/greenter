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
use Greenter\See;
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
        $see->setCredentials('20000000001MODDATOS', 'moddatos');
        $see->setCertificate(file_get_contents(__DIR__.'/../Resources/SFSCert.pem'));

        return $see;
    }
}
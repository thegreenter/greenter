<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/10/2017
 * Time: 05:15 PM
 */

namespace Tests\Greenter;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Tests\Greenter\Factory\CeFactoryBase;

/**
 * Class SeeCeTest
 * @package Tests\Greenter
 */
class SeeCeTest extends CeFactoryBase
{
    public function testSendDespatch()
    {
        $doc = $this->getDespatch();

        /**@var $result BillResult*/
        $result = $this->getSee(SunatEndpoints::GUIA_BETA)->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains(
            'aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @dataProvider providerBillDocs
     * @param DocumentInterface $doc
     */
    public function testSendBill(DocumentInterface $doc)
    {
        /**@var $result BillResult*/
        $result = $this->getSee(SunatEndpoints::RETENCION_BETA)->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertContains(
            'aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testSendSummary()
    {
        $doc = $this->getReversion();
        /**@var $result SummaryResult*/
        $result = $this->getSee(SunatEndpoints::RETENCION_BETA)->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    public function providerBillDocs()
    {
        return [
            [$this->getRetention()],
            [$this->getPerception()],
        ];
    }

    private function getSee($endpoint)
    {
        $see = new See();
        $see->setService($endpoint);
        $see->setCredentials('20000000001MODDATOS', 'moddatos');
        $see->setCertificate(file_get_contents(__DIR__.'/../Resources/SFSCert.pem'));

        return $see;
    }
}
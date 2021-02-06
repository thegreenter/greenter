<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/10/2017
 * Time: 05:15 PM
 */

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Tests\Greenter\Factory\CeFactoryBase;

/**
 * Class SeeCeTest
 * @group integration
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
        $this->assertStringContainsString(
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
        $this->assertStringContainsString(
            'aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @throws \Exception
     */
    public function testSendReversion()
    {
        $doc = $this->getReversion();
        /**@var $result SummaryResult*/
        $result = $this->getSee(SunatEndpoints::RETENCION_BETA)->send($doc);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    /**
     * @dataProvider providerBillDocs
     * @param DocumentInterface $doc
     */
    public function testGetXmlSigned(DocumentInterface $doc)
    {
        $xmlSigned = $this->getSee(SunatEndpoints::RETENCION_BETA)->getXmlSigned($doc);

        $this->assertNotEmpty($xmlSigned);
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
        $see->setBuilderOptions([
            'strict_variables' => true,
            'optimizations' => 0,
            'debug' => true,
            'cache' => false,
        ]);
        $see->setCredentials('20123456789MODDATOS', 'moddatos');
        $see->setCertificate(file_get_contents(__DIR__.'/../Resources/SFSCert.pem'));

        return $see;
    }
}
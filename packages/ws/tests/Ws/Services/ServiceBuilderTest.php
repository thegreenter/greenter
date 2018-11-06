<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 6/11/2018
 * Time: 12:25
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\ServiceBuilder;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsdlProvider;

/**
 * Class ServiceBuilderTest
 */
class ServiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->builder = new ServiceBuilder();
        $this->builder
            ->setUrl(SunatEndpoints::FE_BETA)
            ->setUser('20123456789MODDATOS')
            ->setPassword('moddatos');
    }

    /**
     * @throws \Exception
     */
    public function testCreateBillService()
    {
        /**@var $service BillSender */
        $service = $this->builder->build(BillSender::class);

        $this->assertInstanceOf(BillSender::class, $service);

        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $result = $service->send($nameXml, $xml);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getCdrResponse()->isAccepted());
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidClass()
    {
        $this->builder->build(SunatEndpoints::class);
    }

    /**
     * @throws \Exception
     */
    public function testCreateExtService()
    {
        /**@var $service ExtService */
        $service = $this->builder->build(ExtService::class);

        $this->assertInstanceOf(ExtService::class, $service);

        $result = $service->getStatus('2312312');

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrResponse());
    }

    /**
     * @throws \Exception
     */
    public function testCreateConsultService()
    {
        $builder = new ServiceBuilder();
        $service = $builder
            ->setUrl(SunatEndpoints::FE_CONSULTA_CDR)
            ->setWsdl(WsdlProvider::getConsultPath())
            ->setWsdlParams([])
            ->setUser('20123456789MODDATOS')
            ->setPassword('moddatos')
            ->build(ConsultCdrService::class);

        /**@var $service ConsultCdrService */
        $this->assertInstanceOf(ConsultCdrService::class, $service);

        $result = $service->getStatus('20123456789', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrResponse());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 6/11/2018
 * Time: 12:25
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Builder\ServiceBuilder;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsClientInterface;
use Mockery;

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
    }

    /**
     * @throws \Exception
     */
    public function testCreateBillService()
    {
        $this->builder->setClient($this->getClientMock());
        /**@var $service BillSender */
        $service = $this->builder->build(BillSender::class);

        $this->assertInstanceOf(BillSender::class, $service);

        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");

        $result = $service->send($nameXml, $xml);

        $this->assertTrue($result->isSuccess());
        $this->assertFalse($result->getCdrResponse()->isAccepted());
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
        $this->builder->setClient($this->getClientMock());
        $service = $this->builder->build(ExtService::class);

        $this->assertInstanceOf(ExtService::class, $service);

        $result = $service->getStatus('2312312');

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrResponse());
    }

    /**
     * @return WsClientInterface
     */
    private function getClientMock()
    {
        $obj = new \stdClass();
        $obj->status = new \stdClass();
        $obj->status->statusCode = '98';

        $obj2 = new \stdClass();
        $obj2->applicationResponse = file_get_contents(__DIR__.'/../../Resources/cdr-rechazo.zip');

        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
                ->with('getStatus', Mockery::type('array'))
                ->andReturn($obj);
        $client->shouldReceive('call')
                ->with('sendBill', Mockery::type('array'))
                ->andReturn($obj2);

        return $client;
    }
}
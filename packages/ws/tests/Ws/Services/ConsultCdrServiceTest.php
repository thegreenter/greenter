<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/09/2018
 * Time: 15:16.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\WsClientInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use SoapFault;

class ConsultCdrServiceTest extends TestCase
{
    use ConsultCdrServiceTrait;

    /**
     * @group integration
     */
    public function testGetStatusInvalidUser()
    {
        $service = $this->getConsultService();

        $result = $service->getStatus('20000000001', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0102', $result->getError()->getCode());
    }

    /**
     * @group integration
     */
    public function testGetStatusCdrInvalidUser()
    {
        $service = $this->getConsultService();

        $result = $service->getStatusCdr('20000000001', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrZip());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0102', $result->getError()->getCode());
    }

    public function testGetStatus()
    {
        $wss = $this->getConsultServiceMock();
        $result = $wss->getStatus('20000000001', '01', 'F001', 1);

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('0', $result->getCode());
        $this->assertNotEmpty($result->getMessage());
        $this->assertNull($result->getCdrResponse());
        $this->assertStringContainsString('aceptada', strtolower($result->getMessage()));
    }

    public function testGetCdrStatus()
    {
        $wss = $this->getConsultServiceMock();
        $result = $wss->getStatusCdr('20000000001', '01', 'F001', 1);

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('0', $result->getCode());
        $this->assertNotEmpty($result->getMessage());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertStringContainsString('aceptada', $result->getCdrResponse()->getDescription());
    }

    public function testGetErrorCodeFromCdr()
    {
        $wss = $this->getConsultServiceMock();
        $result = $wss->getStatusCdr('20600995805', '01', 'F001', 2);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertGreaterThan(0, intval($result->getError()->getCode()));
    }

    public function testHttpUnauthorizedFaultMapsToCredentialsError()
    {
        $service = $this->getConsultServiceThrow(new SoapFault('HTTP', 'Unauthorized'));

        foreach (['getStatus', 'getStatusCdr'] as $method) {
            $result = $service->{$method}('20000000001', '01', 'F001', 1);

            $this->assertFalse($result->isSuccess());
            $this->assertNull($result->getCdrZip());
            $this->assertEquals('0102', $result->getError()->getCode());
            $this->assertEquals('Usuario o contraseña incorrectos (HTTP 401 Unauthorized).', $result->getError()->getMessage());
        }
    }

    public function testHttpUnauthorizedFaultUsesCodeProviderMessage()
    {
        $provider = Mockery::mock(ErrorCodeProviderInterface::class);
        $provider->shouldReceive('getValue')->with('0102')->andReturn('Usuario o contraseña incorrectos');

        $service = $this->getConsultServiceThrow(new SoapFault('HTTP', 'Unauthorized'));
        $service->setCodeProvider($provider);

        $result = $service->getStatus('20000000001', '01', 'F001', 1);

        $this->assertEquals('0102', $result->getError()->getCode());
        $this->assertEquals('Usuario o contraseña incorrectos', $result->getError()->getMessage());
    }

    public function testOtherHttpFaultKeepsHttpCode()
    {
        $service = $this->getConsultServiceThrow(new SoapFault('HTTP', 'Service Unavailable'));

        $result = $service->getStatus('20000000001', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('HTTP', $result->getError()->getCode());
        $this->assertEquals('Service Unavailable', $result->getError()->getMessage());
    }

    private function getConsultServiceThrow(SoapFault $fault): ConsultCdrService
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')->andThrow($fault);

        $service = new ConsultCdrService();
        $service->setClient($client);

        return $service;
    }
}

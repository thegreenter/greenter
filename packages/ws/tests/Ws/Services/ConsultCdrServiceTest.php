<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/09/2018
 * Time: 15:16.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use PHPUnit\Framework\TestCase;

class ConsultCdrServiceTest extends TestCase
{
    use ConsultCdrServiceTrait;

    public function testGetStatusInvalidUser()
    {
        $service = $this->getConsultService();

        $result = $service->getStatus('20000000001', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('00103', $result->getError()->getCode());
    }

    public function testGetStatusCdrInvalidUser()
    {
        $service = $this->getConsultService();

        $result = $service->getStatusCdr('20000000001', '01', 'F001', 1);

        $this->assertFalse($result->isSuccess());
        $this->assertNull($result->getCdrZip());
        $this->assertNotNull($result->getError());
        $this->assertEquals('00103', $result->getError()->getCode());
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
}

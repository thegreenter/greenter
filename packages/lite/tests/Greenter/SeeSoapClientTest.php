<?php

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\See;
use Greenter\Ws\Services\SoapClient;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class SeeSoapClientTest extends TestCase
{
    public function testUseInjectedSoapClient(): void
    {
        $client = SoapClient::createSecure();
        $see = new See($client);

        $this->assertSame($client, $this->getWsClient($see));
    }

    public function testDefaultSoapClient(): void
    {
        $this->assertInstanceOf(SoapClient::class, $this->getWsClient(new See()));
    }

    private function getWsClient(See $see)
    {
        $property = new ReflectionProperty(See::class, 'wsClient');
        $property->setAccessible(true);

        return $property->getValue($see);
    }
}

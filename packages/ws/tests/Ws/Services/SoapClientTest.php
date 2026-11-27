<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\SoapClient;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class SoapClientTest extends TestCase
{
    public function testSecureParametersVerifyPeer(): void
    {
        $params = SoapClient::secureParameters();
        $ssl = stream_context_get_options($params['stream_context'])['ssl'];

        $this->assertTrue($ssl['verify_peer']);
        $this->assertTrue($ssl['verify_peer_name']);
        $this->assertFalse($ssl['allow_self_signed']);
    }

    public function testSecureParametersMergeSslOptions(): void
    {
        $params = SoapClient::secureParameters(['cafile' => '/tmp/cacert.pem']);
        $ssl = stream_context_get_options($params['stream_context'])['ssl'];

        $this->assertTrue($ssl['verify_peer']);
        $this->assertSame('/tmp/cacert.pem', $ssl['cafile']);
    }

    public function testDefaultVerifyPeer(): void
    {
        $ssl = $this->getSslOptions(new SoapClient());

        $this->assertTrue($ssl['verify_peer']);
        $this->assertTrue($ssl['verify_peer_name']);
        $this->assertFalse($ssl['allow_self_signed']);
    }

    public function testDefaultVerifyPeerWithParameters(): void
    {
        $ssl = $this->getSslOptions(new SoapClient('', ['trace' => true]));

        $this->assertTrue($ssl['verify_peer']);
    }

    public function testCustomStreamContext(): void
    {
        $context = stream_context_create(['ssl' => ['cafile' => '/tmp/cacert.pem']]);
        $ssl = $this->getSslOptions(new SoapClient('', ['stream_context' => $context]));

        $this->assertSame(['cafile' => '/tmp/cacert.pem'], $ssl);
    }

    public function testCreateSecure(): void
    {
        $client = SoapClient::createSecure();

        $this->assertInstanceOf(SoapClient::class, $client);
        $this->assertNotEmpty($client->__getFunctions());
    }

    private function getSslOptions(SoapClient $client): array
    {
        $property = new ReflectionProperty(\SoapClient::class, '_stream_context');
        $property->setAccessible(true);

        return stream_context_get_options($property->getValue($client))['ssl'];
    }
}

<?php

namespace Tests\Greenter\Ws\Api;

use Greenter\Api\ApiFactory;
use Greenter\Api\InMemoryStore;
use Greenter\Services\Api\BasicToken;
use Greenter\Sunat\GRE\Api\AuthApiInterface;
use Greenter\Sunat\GRE\Api\CpeApi;
use Greenter\Sunat\GRE\Model\ApiToken;
use GuzzleHttp\ClientInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class ApiFactoryTest extends TestCase
{
    public function testCreate()
    {
        list ($auth, $client, $store) = $this->deps();
        $factory = new ApiFactory($auth, $client, $store, null);
        $api = $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
        $token = $store->get('x');

        $this->assertInstanceOf(CpeApi::class, $api);
        $this->assertNotNull($token);

        $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
        $token2 = $store->get('x'); // no changes

        $this->assertEquals($token, $token2);
    }

    private function deps(): array
    {
        $auth = Mockery::mock(AuthApiInterface::class);
        $auth->shouldReceive('getToken')
                ->once()
                ->andReturn(new ApiToken([
                    'access_token' => 'xxxx.xxxx.xxxx',
                    'token_type' => 'bearer',
                    'expires_in' => 3600,
                ]));

        $client = Mockery::mock(ClientInterface::class);
        return [$auth, $client, new InMemoryStore()];
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
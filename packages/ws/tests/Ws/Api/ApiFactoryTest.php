<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Api;

use DateTime;
use Greenter\Api\ApiFactory;
use Greenter\Api\InMemoryStore;
use Greenter\Services\InvalidServiceResponseException;
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
        list ($auth, $client, $store) = $this->deps(2, null);
        $factory = new ApiFactory($auth, $client, $store, null);
        $api = $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
        $token = $store->get('x');

        $this->assertInstanceOf(CpeApi::class, $api);
        $this->assertNotNull($token);

        $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
        $token2 = $store->get('x'); // no changes

        $this->assertEquals($token, $token2);

        // get token if expireIn < 10min
        $store->set('x', $token->setValue('xx')->setExpire(new DateTime('+9 minutes')));
        $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
    }

    public function testInvalidToken()
    {
        $this->expectException(InvalidServiceResponseException::class);
        list ($auth, $client, $store) = $this->deps(1,'');
        $factory = new ApiFactory($auth, $client, $store, null);
        $factory->create('x', 'x', '20123456780MODDATOS', 'moddatos');
    }

    private function deps(int $times, ?string $token): array
    {
        $auth = Mockery::mock(AuthApiInterface::class);
        $auth->shouldReceive('getToken')
                ->times($times)
                ->andReturn(new ApiToken([
                    'access_token' => $token ?? 'xxxx.xxxx.xxxx',
                    'token_type' => 'JWT',
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

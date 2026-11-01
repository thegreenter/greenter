<?php

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\Api;
use Greenter\Api\ApiFactory;
use Greenter\Api\InMemoryStore;
use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;
use Greenter\Sunat\GRE\Api\AuthApiInterface;
use GuzzleHttp\ClientInterface;
use LogicException;
use PHPUnit\Framework\TestCase;
use Throwable;

class ApiTokenStoreTest extends TestCase
{
    public function testUsesConfiguredTokenStore(): void
    {
        $store = new class implements TokenStoreInterface {
            public array $requested = [];

            public function get(?string $id): ?BasicToken
            {
                $this->requested[] = $id;

                return null;
            }

            public function set(?string $id, BasicToken $token): void
            {
            }
        };

        // Endpoint inalcanzable: solo interesa comprobar que se consulta el store.
        $api = (new Api(['auth' => 'http://127.0.0.1:1/v1', 'cpe' => 'http://127.0.0.1:1/v1']))
            ->setApiCredentials('client-id', 'secret')
            ->setClaveSOL('20123456789', 'MODDATOS', 'moddatos')
            ->setTokenStore($store);

        try {
            $api->getStatus('ticket');
        } catch (Throwable $e) {
        }

        $this->assertEquals(['client-id'], $store->requested);
    }

    public function testSetTokenStoreWithCustomFactory(): void
    {
        $this->expectException(LogicException::class);

        $factory = new ApiFactory(
            $this->createMock(AuthApiInterface::class),
            $this->createMock(ClientInterface::class),
            new InMemoryStore(),
            null
        );

        (new Api(null, $factory))->setTokenStore(new InMemoryStore());
    }
}

<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Api;

use DateTime;
use Greenter\Api\Psr16TokenStore;
use Greenter\Services\Api\BasicToken;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

class Psr16TokenStoreTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testSetUsesTokenExpirationAsTtl(): void
    {
        $expire = new DateTime('+1 hour');
        $key = 'greenter_gre_token_'.sha1('client-id');

        $cache = Mockery::mock(CacheInterface::class);
        $cache->shouldReceive('set')
            ->once()
            ->withArgs(function ($k, $value, $ttl) use ($key, $expire) {
                return $k === $key
                    && $value === ['value' => 'xxxx', 'expire' => $expire->getTimestamp()]
                    && $ttl > 3590 && $ttl <= 3600;
            })
            ->andReturn(true);

        (new Psr16TokenStore($cache))->set('client-id', new BasicToken('xxxx', $expire));
    }

    public function testGet(): void
    {
        $expire = (new DateTime('+30 minutes'))->getTimestamp();
        $cache = Mockery::mock(CacheInterface::class);
        $cache->shouldReceive('get')
            ->with('app_'.sha1('client-id'))
            ->andReturn(['value' => 'xxxx', 'expire' => $expire]);

        $token = (new Psr16TokenStore($cache, 'app_'))->get('client-id');

        $this->assertNotNull($token);
        $this->assertEquals('xxxx', $token->getValue());
        $this->assertEquals($expire, $token->getExpire()->getTimestamp());
    }

    /**
     * @dataProvider invalidValues
     */
    public function testGetInvalidOrExpired($value): void
    {
        $cache = Mockery::mock(CacheInterface::class);
        $cache->shouldReceive('get')->andReturn($value);

        $this->assertNull((new Psr16TokenStore($cache))->get('client-id'));
    }

    public function invalidValues(): array
    {
        return [
            'miss' => [null],
            'string' => ['xxxx'],
            'missing expire' => [['value' => 'xxxx']],
            'invalid expire' => [['value' => 'xxxx', 'expire' => 'tomorrow']],
            'expired' => [['value' => 'xxxx', 'expire' => time() - 10]],
        ];
    }

    public function testExpiredTokenIsDeleted(): void
    {
        $cache = Mockery::mock(CacheInterface::class);
        $cache->shouldNotReceive('set');
        $cache->shouldReceive('delete')->twice()->with('greenter_gre_token_'.sha1('client-id'))->andReturn(true);

        $store = new Psr16TokenStore($cache);
        $store->set('client-id', new BasicToken('xxxx', new DateTime('-1 minute')));
        $store->set('client-id', new BasicToken('xxxx', null));
    }
}

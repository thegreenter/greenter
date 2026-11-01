<?php

declare(strict_types=1);

namespace Greenter\Api;

use DateTimeImmutable;
use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Almacena el token de la API GRE en cualquier caché PSR-16 (Redis, APCu, Memcached, Laravel, Symfony, etc.).
 *
 * Requiere el paquete `psr/simple-cache` y una implementación de caché.
 * El TTL de cada entrada coincide con la expiración del token.
 */
class Psr16TokenStore implements TokenStoreInterface
{
    private CacheInterface $cache;
    private string $prefix;

    /**
     * @param CacheInterface $cache
     * @param string         $prefix Prefijo de las claves (no debe contener los caracteres {}()/\@:).
     */
    public function __construct(CacheInterface $cache, string $prefix = 'greenter_gre_token_')
    {
        $this->cache = $cache;
        $this->prefix = $prefix;
    }

    public function get(?string $id): ?BasicToken
    {
        $data = $this->cache->get($this->getKey($id));
        if (!is_array($data)
            || !isset($data['value'], $data['expire'])
            || !is_string($data['value'])
            || !is_int($data['expire'])
            || $data['expire'] <= time()
        ) {
            return null;
        }

        return new BasicToken($data['value'], (new DateTimeImmutable())->setTimestamp($data['expire']));
    }

    public function set(?string $id, BasicToken $token): void
    {
        $key = $this->getKey($id);
        $expire = $token->getExpire();
        $expireAt = $expire === null ? 0 : $expire->getTimestamp();
        $ttl = $expireAt - time();

        if ($token->getValue() === null || $ttl <= 0) {
            $this->cache->delete($key);

            return;
        }

        $this->cache->set($key, [
            'value' => $token->getValue(),
            'expire' => $expireAt,
        ], $ttl);
    }

    private function getKey(?string $id): string
    {
        // Hash para cumplir el formato de claves PSR-16 (caracteres permitidos y longitud).
        return $this->prefix.sha1((string) $id);
    }
}

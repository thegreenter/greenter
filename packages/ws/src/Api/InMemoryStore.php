<?php

declare(strict_types=1);

namespace Greenter\Api;

use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;

class InMemoryStore implements TokenStoreInterface
{
    /**
     * @var BasicToken[]
     */
    private array $tokens = [];

    public function get(?string $id): ?BasicToken
    {
        if (array_key_exists($id, $this->tokens)) {
            return $this->tokens[$id];
        }

        return null;
    }

    public function set(?string $id, BasicToken $token): void
    {
       $this->tokens[$id] = $token;
    }
}

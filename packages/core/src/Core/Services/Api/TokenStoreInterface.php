<?php

declare(strict_types=1);

namespace Greenter\Services\Api;

interface TokenStoreInterface
{
    /**
     * Get Token by id.
     *
     * @param string|null $id
     * @return BasicToken|null
     */
    public function get(?string $id): ?BasicToken;

    /**
     * Save token.
     *
     * @param string|null $id
     * @param BasicToken $token
     * @return void
     */
    public function set(?string $id, BasicToken $token): void;
}

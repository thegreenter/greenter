<?php

declare(strict_types=1);

namespace Greenter\Services\Api;

interface TokenStoreInterface
{
    function get(?string $id): ?BasicToken;

    function set(?string $id, ?BasicToken $token);
}

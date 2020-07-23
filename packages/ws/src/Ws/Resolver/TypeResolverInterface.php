<?php

declare(strict_types=1);

namespace Greenter\Ws\Resolver;

/**
 * Interface TypeResolverInterface
 */
interface TypeResolverInterface
{
    /**
     * @param \DOMDocument|string $value
     * @return string|null
     */
    public function getType($value): ?string;
}
<?php

namespace Greenter\Ws\Resolver;

/**
 * Interface TypeResolverInterface
 */
interface TypeResolverInterface
{
    /**
     * @param \DOMDocument|string $value
     * @return string
     */
    function getType($value);
}
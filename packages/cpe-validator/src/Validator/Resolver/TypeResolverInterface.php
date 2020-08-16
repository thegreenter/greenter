<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

interface TypeResolverInterface
{
    public function getType(?string $xml): ?string;
}

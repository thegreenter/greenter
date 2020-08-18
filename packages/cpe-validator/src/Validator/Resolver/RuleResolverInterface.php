<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

interface RuleResolverInterface
{
    public function getPath(?string $typeDoc): ?string;
}

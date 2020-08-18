<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

use DOMDocument;

interface TypeResolverInterface
{
    public function getType(DOMDocument $doc): ?string;

    public function getTypeFromXml(?string $xml): ?string;
}

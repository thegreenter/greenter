<?php

declare(strict_types=1);

namespace Greenter\Validator\Parser;

use Greenter\Validator\Entity\CpeError;

interface ResultParserInterface
{
    public function parse(?string $raw): ?CpeError;
}

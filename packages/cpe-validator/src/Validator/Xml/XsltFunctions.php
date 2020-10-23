<?php

declare(strict_types=1);

namespace Greenter\Validator\Xml;

use function preg_match;

final class XsltFunctions
{
    public static function matches($pattern, $input)
    {
        $pattern = str_replace('/', '\/', $pattern);

        return preg_match('/'.$pattern.'/', $input);
    }
}
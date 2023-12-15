<?php

namespace Greenter\Xml\Filter;

/**
 * Class FormatFilter.
 * @internal
 */
class FormatFilter
{
    public function number($number, $decimals = 2): ?string
    {
        return number_format($number, $decimals, '.', '');
    }

    public function numberLimit($number, $decimals): ?string
    {
        $numString = (string)$number;
        $applyFormat = $this->getDecimalsLength($numString) > $decimals || strpos($numString, "E") !== false;

        return $applyFormat ? $this->number($number, $decimals) : $number;
    }

    private function getDecimalsLength(string $number): int
    {
        $lasPosition = strrchr($number, '.');
        if ($lasPosition === false) {
            return 0;
        }

        return strlen(substr($lasPosition, 1));
    }
}

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
        $nroDecimals = $this->getDecimalsLenght($number);

        return $nroDecimals > $decimals ? $this->number($number, $decimals) : (string)$number;
    }

    private function getDecimalsLenght($number): int
    {
        $lasPosition = strrchr((string)$number, '.');
        if ($lasPosition === false) {
            return 0;
        }

        return strlen(substr($lasPosition, 1));
    }
}

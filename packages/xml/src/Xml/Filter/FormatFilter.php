<?php

namespace Greenter\Xml\Filter;

/**
 * Class FormatFilter.
 * @internal
 */
class FormatFilter
{
    public function number($number, $decimals = 2)
    {
        return number_format($number, $decimals, '.', '');
    }

    public function numberLimit($number, $decimals)
    {
        $nroDecimals = strlen(substr(strrchr($number, '.'), 1));

        return $nroDecimals > $decimals ? $this->number($number, $decimals) : $number;
    }
}

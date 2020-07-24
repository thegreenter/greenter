<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:28 PM
 */

declare(strict_types=1);

namespace Greenter\Report\Filter;

/**
 * Class FormatFilter
 */
class FormatFilter
{
    public function number($number, $decimals = 2): ?string
    {
        return number_format($number, $decimals, '.', '');
    }
}
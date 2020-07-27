<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 01:47 PM.
 */

declare(strict_types=1);

namespace Greenter\Report\Filter;

use Greenter\Model\Sale\Legend;

/**
 * Class ResolveFilter.
 */
class ResolveFilter
{
    /**
     * @param Legend[] $legends
     * @param string $code
     *
     * @return string
     */
    public function getValueLegend($legends, $code): ?string
    {
        foreach ($legends as $legend) {
            if ($legend->getCode() == $code) {
                return $legend->getValue();
            }
        }

        return '';
    }
}

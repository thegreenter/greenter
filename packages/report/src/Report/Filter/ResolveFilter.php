<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 01:47 PM.
 */

namespace Greenter\Report\Filter;

use Greenter\Model\Sale\Legend;

/**
 * Class ResolveFilter.
 */
class ResolveFilter
{
    /**
     * @param Legend[] $legends
     * @param $code
     *
     * @return string
     */
    public function getValueLegend($legends, $code)
    {
        foreach ($legends as $legend) {
            if ($legend->getCode() == $code) {
                return $legend->getValue();
            }
        }

        return '';
    }
}

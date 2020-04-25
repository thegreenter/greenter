<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/01/2018
 * Time: 20:05
 */

namespace Report\Filter;

use Greenter\Model\Sale\Legend;
use Greenter\Report\Filter\ResolveFilter;

class ResolverFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResolveFilter
     */
    private $filter;

    /**
     * @var Legend[]
     */
    private $legends;

    protected function setUp()
    {
        $this->filter = new ResolveFilter();
        $this->legends = [
            (new Legend())->setCode('1000')->setValue('SON CIENT CON 00/100')
        ];
    }

    public function testGetLegend()
    {
        $result = $this->filter->getValueLegend($this->legends, '1000');

        $this->assertNotEmpty($result);
    }

    public function testGetLegendNotFound()
    {
        $result = $this->filter->getValueLegend($this->legends, '1002');

        $this->assertEmpty($result);
    }
}
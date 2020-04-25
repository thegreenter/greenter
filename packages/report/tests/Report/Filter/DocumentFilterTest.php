<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 20/01/2018
 * Time: 17:13
 */

namespace Report\Filter;

use Greenter\Report\Filter\DocumentFilter;
use PHPUnit\Framework\TestCase;

class DocumentFilterTest extends TestCase
{

    /**
     * @var DocumentFilter
     */
    private $filter;

    protected function setUp()
    {
        $this->filter = new DocumentFilter();
    }

    /**
     * @dataProvider providerCodes
     * @param string $code
     * @param string $value
     */
    public function testGetValueCatalog($code, $value)
    {
        $value = $this->filter->getValueCatalog($value, $code);

        $this->assertNotEmpty($value);
    }

    /**
     * @dataProvider providerBadCodes
     * @param string $code
     * @param string $value
     */
    public function testGetValueCatalogWrong($code, $value)
    {
        $value = $this->filter->getValueCatalog($value, $code);

        $this->assertEmpty($value);
    }

    public function providerCodes()
    {
        return [
          ['01', '01'],
          ['01', '03'],
          ['021', 'PEN'],
          ['021', 'USD'],
        ];
    }

    public function providerBadCodes()
    {
        return [
            ['011', '01'],
            ['01', '50'],
            ['021', 'GB'],
            ['022', 'USD'],
        ];
    }
}
<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Filter;

use Greenter\Xml\Filter\FormatFilter;
use PHPUnit\Framework\TestCase;

class FormatFilterTest extends TestCase
{
    /**
     * @var FormatFilter
     */
    private $formatter;

    protected function setUp(): void
    {
        $this->formatter = new FormatFilter();
    }

    /**
     * @dataProvider getNumberDecimals
     *
     * @param float $number
     * @param int   $decimals
     */
    public function testNumber($number, $decimals)
    {
        $value = $this->formatter->number($number, $decimals);

        $this->assertEquals($decimals, $this->countDecimals($value));
    }

    public function testNumberLimitMax()
    {
        $value = $this->formatter->numberLimit(10.343434223423423, 10);

        $this->assertEquals(10, $this->countDecimals($value));
    }

    public function testNumberLimitMin()
    {
        $number = 432.23;
        $value = $this->formatter->numberLimit($number, 10);

        $this->assertEquals($this->countDecimals((string)$number), $this->countDecimals($value));
    }

    public function getNumberDecimals()
    {
        return [[10.4, 2], [17.22111, 1], [20.677722, 3], [30.22, 0]];
    }

    private function countDecimals(string $number)
    {
        $lasPosition = strrchr($number, '.');
        if ($lasPosition === false) {
            return 0;
        }

        return strlen(substr($lasPosition, 1));
    }
}

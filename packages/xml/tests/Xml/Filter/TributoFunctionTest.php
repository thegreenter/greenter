<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 5/11/2018
 * Time: 18:37
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Filter;

use Greenter\Xml\Filter\TributoFunction;
use PHPUnit\Framework\TestCase;

class TributoFunctionTest extends TestCase
{
    /**
     * @dataProvider getCodes
     * @param string $code
     */
    public function testGetAfectacion($code)
    {
        $value = TributoFunction::getByAfectacion($code);

        $this->assertNotNull($value);
    }

    public function testGetTributoNotFound()
    {
        $value = TributoFunction::getByTributo('2');

        $this->assertNull($value);
    }

    public function getCodes()
    {
        return [[10], [17], [20], [30], [40], [11], [21]];
    }
}
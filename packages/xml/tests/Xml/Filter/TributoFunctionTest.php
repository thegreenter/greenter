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

    /**
     * Catálogo 07: 17 (IVAP) y 40 (exportación) usan 9996 en operaciones gratuitas.
     */
    public function testGetAfectacionGratuita()
    {
        $this->assertSame('1016', TributoFunction::getByAfectacion('17')['id']);
        $this->assertSame('9996', TributoFunction::getByAfectacion('17', true)['id']);
        $this->assertSame('9995', TributoFunction::getByAfectacion('40')['id']);
        $this->assertSame('9996', TributoFunction::getByAfectacion('40', true)['id']);
        $this->assertSame('1000', TributoFunction::getByAfectacion('10', true)['id']);
        $this->assertSame('9996', TributoFunction::getByAfectacion('11', true)['id']);
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
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 27/01/2018
 * Time: 21:01
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Validator\XmlErrorCodeProvider;
use PHPUnit\Framework\TestCase;

class XmlErrorCodeProviderTest extends TestCase
{
    /**
     * @var ErrorCodeProviderInterface
     */
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new XmlErrorCodeProvider();
    }

    public function testGetAllCodes()
    {
        $items = $this->provider->getAll();

        $this->assertNotEmpty($items);
    }

    /**
     * @dataProvider providerCodes
     * @param string $code
     */
    public function testGetErrorMessage($code)
    {
        $msg = $this->provider->getValue($code);

        $this->assertNotEmpty($msg);
    }

    /**
     * @dataProvider providerInvalidCodes
     * @param string|null $code
     */
    public function testGetErrorMessageEmpty($code)
    {
        $msg = $this->provider->getValue($code);

        $this->assertEmpty($msg);
    }

    public function providerCodes()
    {
        return [
          ['0110'],
          ['0200'],
          ['0404'],
          ['1055'],
          ['2630'],
          ['4035'],
          ['4230'],
        ];
    }

    public function providerInvalidCodes()
    {
        return [
            ["x' or @code='0100"],
            [''],
            [null],
            ['A110'],
            ['B200'],
            ['C404'],
            ['D002'],
            ['E011'],
            ['F200'],
            ['G004'],
        ];
    }

    public function testCodesAreSharedBetweenInstances()
    {
        $other = new XmlErrorCodeProvider();

        $this->assertSame($this->provider->getAll(), $other->getAll());
        $this->assertSame('Usuario o contraseña incorrectos', $other->getValue('0102'));
    }
}

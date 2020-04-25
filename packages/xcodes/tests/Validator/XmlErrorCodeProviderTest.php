<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 27/01/2018
 * Time: 21:01
 */

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

        $this->assertEquals(1470, count($items));
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
     * @param string $code
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
            ['A110'],
            ['B200'],
            ['C404'],
            ['D002'],
            ['E011'],
            ['F200'],
            ['G004'],
        ];
    }
}
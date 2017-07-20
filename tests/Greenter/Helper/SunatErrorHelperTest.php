<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 20:00
 */

namespace Tests\Greenter\Helper;

use Greenter\Helper\SunatErrorHelper;

/**
 * Class SunatErrorHelperTest
 * @package Tests\Greenter\Helper
 */
class SunatErrorHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testSearchError()
    {
        $message = $this->getErrorMessage('102');

        $this->assertEquals('Usuario o contraseña incorrectos', $message);
    }

    public function testCodeNotFound()
    {
        $message = $this->getErrorMessage('10233');

        $this->assertEmpty($message);
    }

    /**
     * @dataProvider codesProvider
     * @param string $code
     */
    public function testExistError($code)
    {
        $message = $this->getErrorMessage($code);

        $this->assertNotEmpty($message);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Archivo de errores no existe
     */
    public function testInvalidFileErrors()
    {
        $helper = new SunatErrorHelper();
        $helper->setXmlErrorFile('errors_invalid_file.xml');
    }

    public function codesProvider()
    {
        return [['102'], ['200'], ['2404'], ['4112']];
    }

    private function getErrorMessage($code)
    {
        $helper = new SunatErrorHelper();
        $message = $helper->getMessageByCode($code);
        return $message;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 20:00
 */

namespace Tests\Greenter\Ws\Reader;

use Greenter\Ws\Reader\XmlErrorReader;

/**
 * Class SunatErrorHelperTest
 * @package Tests\Greenter\Zip
 */
class XmlErrorReaderTest extends \PHPUnit_Framework_TestCase
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
        $reader = new XmlErrorReader();
        $reader->setXmlErrorFile('errors_invalid_file.xml');
    }

    public function testSetErrorFile()
    {
        $xmlFile = $this->createXmlErrorFile();

        $reader = new XmlErrorReader();
        $reader->setXmlErrorFile($xmlFile);
        $message = $reader->getMessageByCode('100');

        $this->assertEquals('EMPTY', $message);
        unlink($xmlFile);
    }

    public function codesProvider()
    {
        return [['102'], ['200'], ['2404'], ['4112']];
    }

    private function getErrorMessage($code)
    {
        $reader = new XmlErrorReader();
        $message = $reader->getMessageByCode($code);
        return $message;
    }

    private function createXmlErrorFile()
    {
        $tmp = tempnam("/tmp", "xml");
        file_put_contents($tmp, '<errors><error code="100">EMPTY</error></errors>');

        return $tmp;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 05/10/2017
 * Time: 11:16 AM
 */

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Sale\Note;
use Greenter\Xml\Parser\NoteParser;

/**
 * Class NoteParserTest
 * @package Tests\Greenter\Xml\Greenter\Parser
 */
class NoteParserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreditNoteTest()
    {
        $parser = new NoteParser();
        $xml = file_get_contents(__DIR__.'/../../Resources/notacr-fac.xml');
        /**@var $obj Note */
        $obj = $parser->parse($xml);

        $this->assertEquals('07', $obj->getTipoDoc());
        $this->assertEquals('F001', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getTipDocAfectado());
        $this->assertNotEmpty($obj->getNumDocfectado());
        $this->assertNotEmpty($obj->getCodMotivo());
        $this->assertGreaterThan(0, count($obj->getDetails()));
    }

    public function testDebitNoteTest()
    {
        $parser = new NoteParser();

        $xml = file_get_contents(__DIR__.'/../../Resources/notadb-fac.xml');
        /**@var $obj Note */
        $obj = $parser->parse($xml);

        $this->assertEquals('08', $obj->getTipoDoc());
        $this->assertEquals('F001', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getTipDocAfectado());
        $this->assertNotEmpty($obj->getNumDocfectado());
        $this->assertNotEmpty($obj->getCodMotivo());
        $this->assertGreaterThan(0, count($obj->getDetails()));
    }

    public function testCreditNoteSunatSolTest()
    {
        $parser = new NoteParser();
        $xml = file_get_contents(__DIR__.'/../../Resources/NOTA_CREDITOE001-27.XML');
        /**@var $obj Note */
        $obj = $parser->parse($xml);

        $this->assertEquals('07', $obj->getTipoDoc());
        $this->assertEquals('E001', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getTipDocAfectado());
        $this->assertNotEmpty($obj->getNumDocfectado());
        $this->assertNotEmpty($obj->getCodMotivo());
        $this->assertGreaterThan(0, count($obj->getDetails()));
        $this->assertNotNull($obj->getCompany());
        $this->assertNotNull($obj->getCompany()->getAddress());
        $this->assertNotEmpty($obj->getCompany()->getAddress()->getDireccion());
        $this->assertNotEmpty($obj->getCompany()->getAddress()->getUbigueo());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 05/10/2017
 * Time: 11:16 AM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Parser;

use Greenter\Model\Sale\Note;
use Greenter\Xml\Parser\NoteParser;
use PHPUnit\Framework\TestCase;

/**
 * Class NoteParserTest
 * @package Tests\Greenter\Xml\Greenter\Parser
 */
class NoteParserTest extends TestCase
{
    public function testCreditNote()
    {
        $parser = new NoteParser();
        $xml = file_get_contents(__DIR__ . '/../../Resources/note/notacr-fac.xml');
        /**@var $obj Note */
        $obj = $parser->parse($xml);

        $this->assertEquals('07', $obj->getTipoDoc());
        $this->assertEquals('F001', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getTipDocAfectado());
        $this->assertNotEmpty($obj->getNumDocfectado());
        $this->assertNotEmpty($obj->getCodMotivo());
        $this->assertGreaterThan(0, count($obj->getDetails()));
        $this->assertGreaterThan(1, count($obj->getGuias()));
    }

    public function testParseContrato()
    {
        $parser = new NoteParser();
        $dir = __DIR__ . '/../../Resources/note/';

        /**@var $obj Note */
        $obj = $parser->parse(file_get_contents($dir.'notacr-fac-contrato.xml'));
        $contrato = $obj->getContrato();
        $this->assertNotNull($contrato);
        $this->assertSame(['CCE-2026-014', '1', 'CONSORCIO VIAL DEL SUR', 35.5],
            [$contrato->getNumero(), $contrato->getTipo(), $contrato->getDescripcion(), $contrato->getPorcentaje()]);
        $participante = $obj->getParticipantes()[0];
        $this->assertSame(['6', '20601234567', 'CONSTRUCTORA ANDINA S.A.C.'],
            [$participante->getTipoDoc(), $participante->getNumDoc(), $participante->getRznSocial()]);

        /**@var $without Note */
        $without = $parser->parse(file_get_contents($dir.'notacr-fac.xml'));
        $this->assertNull($without->getContrato());
        $this->assertNull($without->getParticipantes());
    }

    public function testCreditNoteSfs()
    {
        $parser = new NoteParser();
        $xml = file_get_contents(__DIR__ . '/../../Resources/note/20480072872-07-FB99-00001.xml');
        /**@var $obj Note */
        $obj = $parser->parse($xml);

        $this->assertEquals('07', $obj->getTipoDoc());
        $this->assertEquals('FB99', $obj->getSerie());
        $this->assertLessThanOrEqual(8, strlen($obj->getCorrelativo()));
        $this->assertNotEmpty($obj->getTipDocAfectado());
        $this->assertNotEmpty($obj->getNumDocfectado());
        $this->assertNotEmpty($obj->getCodMotivo());
        $this->assertGreaterThan(0, count($obj->getDetails()));
    }

    public function testDebitNoteTest()
    {
        $parser = new NoteParser();

        $xml = file_get_contents(__DIR__ . '/../../Resources/note/notadb-fac.xml');
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

    public function testCreditNoteSunatSol()
    {
        $parser = new NoteParser();
        $xml = file_get_contents(__DIR__ . '/../../Resources/note/NOTA_CREDITOE001-27.XML');
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
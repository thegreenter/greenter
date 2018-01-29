<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 04:14 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Sale\Note;

/**
 * Class FeNoteBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeNoteBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlCreditNote()
    {
        $note = $this->getNote();

        $xml = $this->build($note);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
//         file_put_contents('notecr.xml', $xml);
    }

    public function testCreateXmlDebitNote()
    {
        $note = $this->getNote();
        $note->setTipoDoc('08');

        $xml = $this->build($note);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
        // file_put_contents('notedb.xml', $xml);
    }

    public function testNoteFilename()
    {
        $note = $this->getNote();
        $filename = $note->getName();

        $this->assertEquals($this->getFilename($note), $filename);
    }

    private function getFileName(Note $note)
    {
        $parts = [
            $note->getCompany()->getRuc(),
            $note->getTipoDoc(),
            $note->getSerie(),
            $note->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
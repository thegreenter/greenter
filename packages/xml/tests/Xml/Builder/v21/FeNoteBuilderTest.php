<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 04:14 PM
 */

namespace Tests\Greenter\Xml\Builder\v21;

use Greenter\Data\Generator\NoteStore;
use Greenter\Model\Sale\Note;
use Tests\Greenter\Xml\Builder\FeBuilderTrait;
use Tests\Greenter\Xml\Builder\XsdValidatorTrait;

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
        /**@var $note Note*/
        $note = $this->createDocument(NoteStore::class);
        $note->setUblVersion('2.1');

        $xml = $this->build($note);

//        file_put_contents('notecr.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testCreateXmlDebitNote()
    {
        /**@var $note Note*/
        $note = $this->createDocument(NoteStore::class);
        $note->setTipoDoc('08');
        $note->setUblVersion('2.1');

        $xml = $this->build($note);

//        file_put_contents('notedb.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:47 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\VoidedStore;
use Greenter\Model\Voided\Voided;
use PHPUnit\Framework\TestCase;

/**
 * Class FeVoidedBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeVoidedBuilderTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlVoided()
    {
        $voided = $this->createDocument(VoidedStore::class);

        $xml = $this->build($voided);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testVoidedFilename()
    {
        /**@var $voided Voided */
        $voided = $this->createDocument(VoidedStore::class);
        $filename = $voided->getName();

        $this->assertEquals($this->getFilename($voided), $filename);
    }

    private function getFilename(Voided $voided)
    {
        $parts = [
            $voided->getCompany()->getRuc(),
            'RA',
            $voided->getFecComunicacion()->format('Ymd'),
            $voided->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
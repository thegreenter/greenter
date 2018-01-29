<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:47 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Voided\Voided;

/**
 * Class FeVoidedBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeVoidedBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlVoided()
    {
        $voided = $this->getVoided();

        $xml = $this->build($voided);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testVoidedFilename()
    {
        $voided = $this->getVoided();
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
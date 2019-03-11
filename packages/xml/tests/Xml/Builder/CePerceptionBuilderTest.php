<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:02 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\PerceptionStore;
use Greenter\Model\Perception\Perception;

/**
 * Class CePerceptionBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class CePerceptionBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlPerception()
    {
        $perception = $this->createDocument(PerceptionStore::class);
        $xml = $this->build($perception);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testCreateXmlPerceptionWithoutInformation()
    {
        $perception = $this->createDocument(PerceptionStore::class);

        $xml = $this->build($perception);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testPerceptionFilename()
    {
        /**@var $perception Perception*/
        $perception = $this->createDocument(PerceptionStore::class);
        $filename = $perception->getName();

        $this->assertEquals($this->getFilename($perception), $filename);
    }

    private function getFileName(Perception $perception)
    {
        $parts = [
            $perception->getCompany()->getRuc(),
            '40',
            $perception->getSerie(),
            $perception->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
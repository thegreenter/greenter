<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:02 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use DOMElement;
use Greenter\Data\Generator\PerceptionStore;
use Greenter\Model\Perception\Perception;
use PHPUnit\Framework\TestCase;

/**
 * Class CePerceptionBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class CePerceptionBuilderTest extends TestCase
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

    public function testCreateXmlPerceptionWithIndExcepcional()
    {
        /**@var $perception Perception*/
        $perception = $this->createDocument(PerceptionStore::class);
        $detail = $perception->getDetails()[0];
        $detail->setTipoDoc('01');
        $perception
            ->setDetails([$detail])
            ->setIndExcepcional('01');

        $xml = $this->build($perception);

        $this->assertStringContainsString('<sac:ExceptionalIndicator>01</sac:ExceptionalIndicator>', $xml);

        $names = $this->getRootChildNames($xml);
        $indicator = array_search('sac:ExceptionalIndicator', $names, true);
        $this->assertNotFalse($indicator);
        $this->assertGreaterThan(array_search('cbc:IssueTime', $names, true), $indicator);
        $this->assertLessThan(array_search('cac:AgentParty', $names, true), $indicator);

        $this->assertSchema($xml);
    }

    public function testCreateXmlPerceptionWithoutIndExcepcional()
    {
        $perception = $this->createDocument(PerceptionStore::class);

        $xml = $this->build($perception);

        $this->assertStringNotContainsString('ExceptionalIndicator', $xml);
        $this->assertSchema($xml);
    }

    public function testPerceptionFilename()
    {
        /**@var $perception Perception*/
        $perception = $this->createDocument(PerceptionStore::class);
        $filename = $perception->getName();

        $this->assertEquals($this->getFilename($perception), $filename);
    }

    /**
     * @return string[]
     */
    private function getRootChildNames(string $xml): array
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml);

        $names = [];
        foreach ($doc->documentElement->childNodes as $node) {
            if ($node instanceof DOMElement) {
                $names[] = $node->nodeName;
            }
        }

        return $names;
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
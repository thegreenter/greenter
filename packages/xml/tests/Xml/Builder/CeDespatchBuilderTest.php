<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:18 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Despatch\Despatch;

/**
 * Class CeDespatchBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeDespatchBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlDespatch()
    {
        $despatch = $this->getDespatch();

        $xml = $this->build($despatch);

        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $this->createExtensionContent($doc);

        $this->assertSchema($doc, '2.1');
//         file_put_contents('guia.xml', $xml);
    }

    public function testDespatchFilename()
    {
        $despatch = $this->getDespatch();
        $filename = $despatch->getName();

        $this->assertEquals($this->getFilename($despatch), $filename);
    }

    private function getFileName(Despatch $despatch)
    {
        $parts = [
            $despatch->getCompany()->getRuc(),
            '09',
            $despatch->getSerie(),
            $despatch->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
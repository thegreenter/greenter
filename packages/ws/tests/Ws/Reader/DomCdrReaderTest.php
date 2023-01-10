<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 22/07/2017
 * Time: 16:29.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Reader;

use DOMDocument;
use Exception;
use Greenter\Ws\Reader\DomCdrReader;
use Greenter\Ws\Reader\XmlReader;
use Greenter\Ws\Reader\XmlReaderException;
use PHPUnit\Framework\TestCase;

/**
 * Class DomCdrReaderTest.
 */
class DomCdrReaderTest extends TestCase
{
    /**
     * @var DomCdrReader
     */
    private $reader;

    protected function setUp(): void
    {
        $this->reader = new DomCdrReader(new XmlReader());
    }

    /**
     * @throws Exception
     */
    public function testGetResponse(): void
    {
        $path = __DIR__.'/../../Resources/R-20600995805-01-F001-1.xml';
        $xml = file_get_contents($path);

        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertNotEmpty($cdr);
        $this->assertEquals(0, count($cdr->getNotes()));
        $this->assertEquals('F001-1', $cdr->getId());
        $this->assertEquals('0', $cdr->getCode());
        $this->assertEquals('La Factura numero F001-00000001, ha sido aceptada', $cdr->getDescription());
    }

    public function testCustomNsCdr(): void
    {
        $path = __DIR__.'/../../Resources/efact_cdr1.xml';
        $xml = file_get_contents($path);

        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertNotEmpty($cdr);
        $this->assertEquals(0, count($cdr->getNotes()));
        $this->assertEquals('F001-1', $cdr->getId());
        $this->assertEquals('0', $cdr->getCode());
        $this->assertEquals('La Factura F001-1 ha sido aceptada.', $cdr->getDescription());
    }

    public function testNuevaGuiaCdr(): void
    {
        $path = __DIR__.'/../../Resources/R-20000000001-09-T001-1.xml';
        $xml = file_get_contents($path);

        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertNotEmpty($cdr);
        $this->assertStringStartsWith('https://e-factura.sunat.gob.pe/', $cdr->getReference());
        $this->assertEquals(1, count($cdr->getNotes()));
        $this->assertEquals('T001-1', $cdr->getId());
        $this->assertEquals('0', $cdr->getCode());
        $this->assertEquals('El Comprobante  numero T001-1, ha sido aceptado', $cdr->getDescription());
    }

    /**
     * @throws Exception
     */
    public function testGetResponseWithNotes(): void
    {
        $path = __DIR__.'/../../Resources/R-20600995805-01-F001-3.xml';
        $xml = file_get_contents($path);
        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertNotEmpty($cdr);
        $this->assertEquals(2, count($cdr->getNotes()));
    }

    public function testNotFoundResponse(): void
    {
        $xml = <<<XML
<ar:AppRespnse xmlns:ar="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2"
xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">
    <cac:item>Empty</cac:item>
    <cbc:value>1</cbc:value>
</ar:AppRespnse>
XML;

        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertEmpty($cdr->getId());
        $this->assertEmpty($cdr->getCode());
        $this->assertEmpty($cdr->getDescription());
        $this->assertEmpty($cdr->getNotes());
    }

    /**
     * @throws Exception
     */
    public function testEmptyNodes(): void
    {
        $doc = new DOMDocument();
        $doc->load(__DIR__.'/../../Resources/R-20600995805-01-F001-3.xml');
        $referenceId = $doc->documentElement
                        ->childNodes->item(27)
                        ->childNodes->item(1)
                        ->childNodes->item(1);

        $referenceId->parentNode->removeChild($referenceId);
        $xml = $doc->saveXML();
        $cdr = $this->reader->getCdrResponse($xml);

        $this->assertEmpty($cdr->getId());
    }

    public function testEmptyXml(): void
    {
        $this->expectException(XmlReaderException::class);

        $cdr = $this->reader->getCdrResponse('');

        $this->assertNull($cdr);
    }
}

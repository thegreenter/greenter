<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator\Resolver;

use DOMDocument;
use Greenter\Validator\Entity\DocumentType;
use Greenter\Validator\Resolver\XmlTypeResolver;
use PHPUnit\Framework\TestCase;

class XmlTypeResolverTest extends TestCase
{
    private $baseXmlResources = __DIR__.'/../../../../../packages/xml-parser/tests/Resources';
    private $xmlTypeResolver;

    protected function setUp(): void
    {
        $this->xmlTypeResolver = new XmlTypeResolver();
    }

    /**
     * @dataProvider getXmlData
     */
    public function testGetType($expectedType, $xmlPath)
    {
        $doc = new DOMDocument();
        $doc->load($xmlPath);

        $type = $this->xmlTypeResolver->getType($doc);

        $this->assertEquals($expectedType, $type);
    }

    public function testGetTypeFromXml()
    {
        $xml = file_get_contents($this->baseXmlResources.'/invoice/anticipos.xml');

        $type = $this->xmlTypeResolver->getTypeFromXml($xml);
        $this->assertEquals(DocumentType::FACTURA, $type);
    }

    public function getXmlData()
    {
        return [
          [DocumentType::FACTURA, $this->baseXmlResources.'/invoice/gravada.xml'],
          [DocumentType::BOLETA, $this->baseXmlResources.'/invoice/plazavea-bol.xml'],
          [DocumentType::NOTA_CREDITO, $this->baseXmlResources.'/note/20480072872-07-FB99-00001.xml'],
          [DocumentType::NOTA_DEBITO, $this->baseXmlResources.'/note/notadb-fac.xml'],
          [DocumentType::RESUMEN_DIARIO, $this->baseXmlResources.'/resumen/20268523821-RC-20180127-21.xml'],
          [DocumentType::COMUNICACION_BAJA, $this->baseXmlResources.'/bajas/20338570041-RA-20170628-0008.xml'],
        ];
    }
    public function testNotFoundType()
    {
        $type = $this->xmlTypeResolver->getTypeFromXml('<ApplicationResponse></ApplicationResponse>');

        $this->assertNull($type);
    }
}

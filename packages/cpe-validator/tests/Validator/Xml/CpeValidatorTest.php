<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator\Xml;

use DOMDocument;
use Greenter\Validator\Resolver\TypeResolverInterface;
use Greenter\Validator\Resolver\XslPathResolver;
use Greenter\Validator\Xml\CpeValidator;
use Greenter\Validator\Entity\ErrorLevel;
use Greenter\Validator\Xml\XslValidatorInterface;
use PHPUnit\Framework\TestCase;
use Tests\Greenter\Validator\Factory\CpeValidatorFactory;

class CpeValidatorTest extends TestCase
{
    /**
     * @var CpeValidator
     */
    private $validator;

    protected function setUp(): void
    {
        $factory = new CpeValidatorFactory();
        $this->validator = $factory->create(__DIR__ . '/../../Resources');
    }

    public function testValid()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">
<cbc:UBLVersionID>2.1</cbc:UBLVersionID>
</Invoice>
XML;

        $errors = $this->validator->validateFromXml('2000000001-01-F001-1.xml', $xml);

        $this->assertCount(0, $errors);
    }

    public function testValidWithoutXslSet()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<ApplicationResponse xmlns="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2">
</ApplicationResponse>
XML;

        $errors = $this->validator->validateFromXml('2000000001-01-F001-1.xml', $xml);

        $this->assertCount(1, $errors);
    }

    public function testNotFoundXslRule()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<ApplicationResponse xmlns="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2">
</ApplicationResponse>
XML;
        $resolverStub = $this->createMock(TypeResolverInterface::class);
        $resolverStub->method('getType')->willReturn('00');

        $validator = new CpeValidator($resolverStub, new XslPathResolver(__DIR__), $this->createMock(XslValidatorInterface::class));

        $errors = $validator->validateFromXml('2000000001-01-F001-1.xml', $xml);

        $this->assertCount(1, $errors);
    }

    public function testValidWithErrors()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2">
<cbc:UBLVersionID>2.0</cbc:UBLVersionID>
</Invoice>
XML;

        $doc = new DOMDocument();
        $doc->loadXML($xml);
        $errors = $this->validator->validate('2000000001-01-F001-1.xml', $doc);

        $this->assertNotEmpty($errors);
        $error = $errors[0];
        $this->assertEquals(ErrorLevel::EXCEPTION, $error->getLevel());
        $this->assertNotEmpty($error->getCode());
        $this->assertStringContainsString('UBLVersion', $error->getNodePath());
        $this->assertEquals('2.0', $error->getNodeValue());
    }
}


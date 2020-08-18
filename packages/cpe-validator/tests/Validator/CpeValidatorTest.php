<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use DOMDocument;
use Greenter\Validator\CpeValidator;
use Greenter\Validator\Entity\ErrorLevel;
use PHPUnit\Framework\TestCase;

class CpeValidatorTest extends TestCase
{
    /**
     * @var CpeValidator
     */
    private $validator;

    protected function setUp(): void
    {
        $this->validator = new CpeValidator(__DIR__.'/../Resources');
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

        $this->assertEmpty($errors);
    }

    public function testValidWithoutXslSet()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<ApplicationResponse xmlns="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2">
</ApplicationResponse>
XML;

        $errors = $this->validator->validateFromXml('2000000001-01-F001-1.xml', $xml);

        $this->assertNotEmpty($errors);
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


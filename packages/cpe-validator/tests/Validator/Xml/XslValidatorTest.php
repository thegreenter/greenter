<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator\Xml;

use DOMDocument;
use Greenter\Validator\Parser\ResultParserInterface;
use Greenter\Validator\Xml\XslValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class XslValidatorTest extends TestCase
{
    public function testNotSetXsl()
    {
        $this->expectException(InvalidArgumentException::class);
        $validator = new XslValidator($this->createResultParserMock());
        $docEmpty = new DOMDocument();
        $validator->validate('a.xml', $docEmpty);
    }

    private function createResultParserMock(): ResultParserInterface
    {
        $stub = $this
            ->getMockBuilder(ResultParserInterface::class)
            ->getMock();

        $stub->method('parse')
            ->willReturn(null);

        /**@var ResultParserInterface $stub */
        return $stub;
    }
}
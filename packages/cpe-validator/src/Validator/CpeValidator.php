<?php

declare(strict_types=1);

namespace Greenter\Validator;

use DOMDocument;
use Greenter\Validator\Entity\CpeError;
use Greenter\Validator\Entity\ErrorLevel;
use Greenter\Validator\Parser\ErrorResultParser;
use Greenter\Validator\Resolver\XmlTypeResolver;
use Greenter\Validator\Resolver\XslPathResolver;
use Greenter\Validator\Xml\ValidatorInterface;
use Greenter\Validator\Xml\XslValidator;

class CpeValidator implements ValidatorInterface
{
    /**
     * @var string
     */
    private $xslBasePath;

    /**
     * CpeValidator constructor.
     * @param string $xslBasePath
     */
    public function __construct(string $xslBasePath)
    {
        $this->xslBasePath = $xslBasePath;
    }

    /**
     * @param string $filename
     * @param string $xml
     * @return CpeError[]
     */
    public function validateFromXml(string $filename, string $xml): array
    {
        $document = new DOMDocument();
        $document->loadXML($xml);

        return $this->validate($filename, $document);
    }

    /**
     * @param string $filename
     * @param DOMDocument $document
     * @return CpeError[]
     */
    public function validate(string $filename, DOMDocument $document): array
    {
        $typeResolver = new XmlTypeResolver();
        $type = $typeResolver->getType($document);

        if ($type === null) {
            return [
                (new CpeError())
                    ->setCode('0305')
                    ->setLevel(ErrorLevel::EXCEPTION)
            ];
        }

        $xslResolver = new XslPathResolver($this->xslBasePath);
        $xslPath = $xslResolver->getPath($type);

        $xslValidator = new XslValidator(new ErrorResultParser());

        $xslDoc = new DOMDocument();
        $xslDoc->load($xslPath);

        $xslValidator->setXsl($xslDoc);

        return $xslValidator->validate($filename, $document);
    }
}

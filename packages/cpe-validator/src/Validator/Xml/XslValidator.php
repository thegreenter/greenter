<?php

declare(strict_types=1);

namespace Greenter\Validator\Xml;

use DOMDocument;
use Greenter\Validator\Entity\CpeError;
use Greenter\Validator\Parser\ResultParserInterface;
use InvalidArgumentException;
use XSLTProcessor;

class XslValidator implements XslValidatorInterface
{
    /**
     * @var DOMDocument
     */
    private $xslDocument;

    /**
     * @var ResultParserInterface
     */
    private $errorParser;

    /**
     * XslValidator constructor.
     *
     * @param ResultParserInterface $errorParser
     */
    public function __construct(ResultParserInterface $errorParser)
    {
        $this->errorParser = $errorParser;
    }

    public function setXsl(DOMDocument $xslDocument)
    {
        $this->xslDocument = $xslDocument;
    }

    /**
     * @param string $filename
     * @param DOMDocument $document
     *
     * @return CpeError[]
     */
    public function validate(string $filename, DOMDocument $document): array
    {
        if ($this->xslDocument === null) {
            throw new InvalidArgumentException('XslDocument no set');
        }

        $proc = new XsltProcessor();

        $proc->importStylesheet($this->xslDocument);
        $proc->registerPHPFunctions(['preg_match']);
        $proc->setParameter('', 'nombreArchivoEnviado', $filename);

        $state = libxml_use_internal_errors(true);
        $proc->transformToXML($document);

        $errors = $this->getErrors(libxml_get_errors());

        libxml_clear_errors();
        libxml_use_internal_errors($state);

        return $errors;
    }

    /**
     * @param \LibXMLError[]|null $xmlErrors
     *
     * @return CpeError[]
     */
    private function getErrors(?array $xmlErrors): array
    {
        $errors = [];
        foreach ($xmlErrors as $xmlError) {
            $error = $this->errorParser->parse($xmlError->message);

            if ($error !== null) {
                $errors[] = $error;
            }

        }

        return $errors;
    }
}

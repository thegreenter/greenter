<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/10/2017
 * Time: 12:18
 */

namespace Greenter\Xml;
use Greenter\Parser\DocumentParserInterface;
use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;

/**
 * Class ParserResolver
 * @package Greenter\Xml
 */
class ParserResolver
{
    /**
     * @var \DOMDocument
     */
    private $doc;

    /**
     * @param string $xml
     */
    public function loadXml($xml)
    {
        $doc = new \DOMDocument($xml);
        $doc->loadXML($xml);
        $this->doc = $doc;
    }

    /**
     * @param \DOMDocument $document
     */
    public function load(\DOMDocument $document)
    {
        $this->doc = $document;
    }

    /**
     * @return DocumentParserInterface|null
     * @throws \Exception
     */
    public function getParser()
    {
        if (empty($this->doc)) {
            throw new \Exception('require load xml');
        }
        $name = $this->doc->documentElement->localName;
        switch ($name) {
            case 'Invoice':
                return new InvoiceParser();
            case 'CreditNote':
            case 'DebitNote':
                return new NoteParser();
        }

        return null;
    }
}
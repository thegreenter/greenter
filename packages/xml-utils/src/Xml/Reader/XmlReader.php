<?php

declare(strict_types=1);

namespace Greenter\Xml\Reader;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;

class XmlReader
{
    /**
     * @var DOMXPath
     */
    private $xpath;

    /**
     * XmlReader constructor.
     *
     * @param DOMXPath $xpath
     */
    public function __construct(DOMXPath $xpath)
    {
        $this->xpath = $xpath;
    }

    public function load(DOMDocument $document)
    {
        $this->xpath = new DOMXPath($document);
    }

    public function getText(string $query, ?string $default = '', DOMNode $node = null): ?string
    {
        $result = $this->getList($query, $node);

        if ($result->length === 0) {
            return $default;
        }

        return $result->item(0)->nodeValue;
    }

    public function getList(string $query, DOMNode $node = null): DOMNodeList
    {
        if ($node === null) {
            $node = $this->xpath->document->documentElement;
        }

        return $this->xpath->query($query, $node);
    }
}

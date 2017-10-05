<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 05/10/2017
 * Time: 08:29
 */

namespace Greenter\Xml;

/**
 * Class XmlParserReader
 * @package Greenter\Xml
 */
class XmlParserReader
{
    /**
     * @var \DOMDocument
     */
    private $doc;

    /**
     * @var \DOMXPath
     */
    private $xpath;

    /**
     * @param string $xml
     */
    public function loadXml($xml)
    {
        $this->doc = new \DOMDocument();
        $this->doc->loadXML($xml);
        $this->createXpath();
    }

    /**
     * @param \DOMDocument $document
     */
    public function loadDom(\DOMDocument $document)
    {
        $this->doc = $document;
        $this->createXpath();
    }

    /**
     * @param string $query                 Query xpath
     * @param string $def                   Default Value
     * @param \DomNode|null $context        Context node
     * @return string
     */
    public function getValue($query, $def = '', $context = null)
    {
        $nodes = $this->xpath->query($query, $context);
        if ($nodes->length == 0) {
            return $def;
        }

        return $nodes->item(0)->nodeValue;
    }

    /**
     * @param string        $query
     * @param \DOMNode|null $context
     * @return \DOMElement|null
     */
    public function getNode($query, $context = null)
    {
        $nodes = $this->getNodes($query, $context);
        if ($nodes->length == 0) {
            return null;
        }

        return $nodes->item(0);
    }

    /**
     * @param string        $query
     * @param \DOMNode|null $context
     * @return \DOMNodeList
     */
    public function getNodes($query, $context = null)
    {
        return $this->xpath->query($query, $context);
    }

    private function createXpath()
    {
        $this->xpath = new \DOMXPath($this->doc);
    }
}
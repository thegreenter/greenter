<?php
/**
 * Created by PhpStorm.
 * User: giansalex
 * Date: 30/01/2019
 * Time: 10:01.
 */

namespace Greenter\Ws\Reader;

/**
 * Class XmlReader.
 */
class XmlReader
{
    /**
     * Prefix namespace.
     */
    const ROOT_PREFIX = 'x';

    /**
     * @var \DOMXPath
     */
    private $xpath;

    /**
     * @return \DOMXPath
     */
    public function getXpath()
    {
        return $this->xpath;
    }

    /**
     * @var string
     */
    private $rootNs;

    /**
     * Load document from XML.
     *
     * @param string $content
     *
     * @return \DOMDocument
     */
    public function getDocument($content)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        return $doc;
    }

    /**
     * Parse value to document.
     *
     * @param \DOMDocument|string $value
     *
     * @return \DOMDocument
     */
    public function parseToDocument($value)
    {
        if ($value instanceof \DOMDocument) {
            return $value;
        }

        return $this->getDocument($value);
    }

    /**
     * Init XPath.
     *
     * @param \DOMDocument|string $value
     */
    public function loadXpath($value)
    {
        $doc = $this->parseToDocument($value);

        $this->loadXpathFromDoc($doc);
    }

    /**
     * Init XPath from document.
     *
     * @param \DOMDocument $doc
     */
    public function loadXpathFromDoc(\DOMDocument $doc)
    {
        $docName = $doc->documentElement->nodeName;
        $this->rootNs = '/'.self::ROOT_PREFIX.':'.$docName;
        $this->xpath = new \DOMXPath($doc);
        $this->xpath->registerNamespace(self::ROOT_PREFIX, $doc->documentElement->namespaceURI);
    }

    /***
     * Obtiene el primer valor del nodo.
     *
     * @param string $query Relativo al root namespace
     * @return null|string
     */
    public function getValue($query)
    {
        $nodes = $this->xpath->query($this->rootNs.'/'.$query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }

        return null;
    }
}

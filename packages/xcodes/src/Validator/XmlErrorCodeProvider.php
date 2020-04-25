<?php

namespace Greenter\Validator;

/**
 * Class XmlErrorCodeProvider.
 */
class XmlErrorCodeProvider implements ErrorCodeProviderInterface
{
    private $xmlErrorFile;

    /**
     * XmlErrorCodeProvider constructor.
     */
    public function __construct()
    {
        $this->xmlErrorFile = __DIR__.'/../data/CodeErrors.xml';
    }

    /**
     * Get all codes and messages.
     *
     * @return array
     */
    public function getAll()
    {
        $xpath = $this->getXpath();
        $nodes = $xpath->query('/errors/error');

        $items = [];
        foreach ($nodes as $node) {
            /** @var $node \DOMElement */
            $key = $node->getAttribute('code');
            $items[$key] = $node->nodeValue;
        }

        return $items;
    }

    /**
     * Get Error Message by code.
     *
     * @param string $code
     *
     * @return string
     */
    public function getValue($code)
    {
        $xpath = $this->getXpath();
        $nodes = $xpath->query("/errors/error[@code='$code']");

        if ($nodes->length !== 1) {
            return '';
        }

        return $nodes[0]->nodeValue;
    }

    private function getXpath()
    {
        $doc = new \DOMDocument();
        $doc->load($this->xmlErrorFile);
        $xpath = new \DOMXPath($doc);

        return $xpath;
    }
}

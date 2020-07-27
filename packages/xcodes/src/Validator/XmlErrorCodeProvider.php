<?php

declare(strict_types=1);

namespace Greenter\Validator;

use DOMDocument;
use DOMElement;
use DOMXPath;

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
    public function getAll(): ?array
    {
        $xpath = $this->getXpath();
        $nodes = $xpath->query('/errors/error');

        $items = [];
        foreach ($nodes as $node) {
            /** @var DOMElement $node */
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
    public function getValue(?string $code): ?string
    {
        $xpath = $this->getXpath();
        $nodes = $xpath->query("/errors/error[@code='$code']");

        if ($nodes->length !== 1) {
            return '';
        }

        return $nodes[0]->nodeValue;
    }

    private function getXpath(): DOMXPath
    {
        $doc = new DOMDocument();
        $doc->load($this->xmlErrorFile);

        return new DOMXPath($doc);
    }
}

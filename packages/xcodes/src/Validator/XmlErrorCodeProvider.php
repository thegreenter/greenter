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
    /**
     * @var array<string, array<string, string>>
     */
    private static $cache = [];

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
        return $this->getCodes();
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
        $codes = $this->getCodes();

        return isset($code, $codes[$code]) ? $codes[$code] : '';
    }

    /**
     * Los códigos se cargan una sola vez por archivo y se comparten entre instancias.
     *
     * @return array<string, string>
     */
    private function getCodes(): array
    {
        if (!isset(self::$cache[$this->xmlErrorFile])) {
            self::$cache[$this->xmlErrorFile] = $this->loadCodes();
        }

        return self::$cache[$this->xmlErrorFile];
    }

    private function loadCodes(): array
    {
        $doc = new DOMDocument();
        $doc->load($this->xmlErrorFile);
        $nodes = (new DOMXPath($doc))->query('/errors/error');

        $items = [];
        foreach ($nodes as $node) {
            /** @var DOMElement $node */
            $items[$node->getAttribute('code')] = $node->nodeValue;
        }

        return $items;
    }
}

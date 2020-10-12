<?php

declare(strict_types=1);

namespace Greenter\Xml\Parser;

use DOMDocument;
use Greenter\Xml\XmlReader;

trait XmlLoaderTrait
{
    /**
     * @param mixed $value
     * @return XmlReader
     */
    private function load($value): XmlReader
    {
        $reader = new XmlReader();

        if ($value instanceof DOMDocument) {
            $reader->loadDom($value);
            return $reader;
        }

        $reader->loadXml($value);
        return $reader;
    }
}
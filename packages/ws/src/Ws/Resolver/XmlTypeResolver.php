<?php

namespace Greenter\Ws\Resolver;

use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;

class XmlTypeResolver implements TypeResolverInterface
{
    const ROOT_PREFIX = 'x';
    private $rootNs;

    /**
     * @param \DOMDocument|string $value
     * @return string
     */
    function getType($value)
    {
        $doc = $this->getDoc($value);
        $name = $doc->documentElement->nodeName;

        switch ($name) {
            case 'Invoice':
                return Invoice::class;
            case 'CreditNote':
            case 'DebitNote':
                return Note::class;
            case 'Perception':
                return Perception::class;
            case 'Retention':
                return Retention::class;
            case 'SummaryDocuments':
                return Summary::class;
            case 'VoidedDocuments':
                $xpath = $this->getXPath($doc);
                $id = $this->getValue($xpath,'cbc:ID');
                return substr($id,0, 2) === 'RA' ? Voided::class : Reversion::class;
        }

        return '';
    }

    public function getDoc($value)
    {
        if ($value instanceof \DOMDocument) {
            return $value;
        }

        $doc = new \DOMDocument();
        $doc->loadXML($value);

        return $doc;
    }

    public function getXPath(\DOMDocument $document)
    {
        $xpath = new \DOMXPath($document);
        $docName = $document->documentElement->nodeName;
        $this->rootNs = '/' . self::ROOT_PREFIX . ':' . $docName;
        $xpath->registerNamespace(self::ROOT_PREFIX, $document->documentElement->namespaceURI);

        return $xpath;
    }

    private function getValue(\DOMXPath $xpath, $query)
    {
        $nodes = $xpath->query($this->rootNs . '/' . $query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }
        return null;
    }
}
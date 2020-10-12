<?php

declare(strict_types=1);

namespace Greenter\Ws\Resolver;

use DOMDocument;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Ws\Reader\XmlReader;

class XmlTypeResolver implements TypeResolverInterface
{
    /**
     * @var XmlReader
     */
    private $reader;

    /**
     * XmlTypeResolver constructor.
     *
     * @param XmlReader $reader
     */
    public function __construct(XmlReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param DOMDocument|string $value
     *
     * @return string|null
     */
    public function getType($value): ?string
    {
        $doc = $this->reader->parseToDocument($value);
        $name = $doc->documentElement->localName;

        switch ($name) {
            case 'Invoice':
                return Invoice::class;
            case 'CreditNote':
            case 'DebitNote':
                return Note::class;
            case 'DespatchAdvice':
                return Despatch::class;
            case 'Perception':
                return Perception::class;
            case 'Retention':
                return Retention::class;
            case 'SummaryDocuments':
                return Summary::class;
            case 'VoidedDocuments':
                return $this->getFromVoidedDoc($doc);
            default:
                return '';
        }
    }

    private function getFromVoidedDoc(DOMDocument $doc)
    {
        $this->reader->loadXpathFromDoc($doc);
        $id = $this->reader->getValue('cbc:ID');

        return 'RA' === substr($id, 0, 2) ? Voided::class : Reversion::class;
    }
}

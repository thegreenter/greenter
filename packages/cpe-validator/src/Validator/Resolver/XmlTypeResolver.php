<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

use DOMDocument;
use DOMXPath;
use Greenter\Validator\Entity\DocumentType;

class XmlTypeResolver implements TypeResolverInterface
{
    public function getType(DOMDocument $doc): ?string
    {
        $docName = $doc->documentElement->localName;
        switch ($docName) {
            case 'Invoice': return $this->fromInvoice($doc);
            case 'CreditNote': return DocumentType::NOTA_CREDITO;
            case 'DebitNote': return DocumentType::NOTA_DEBITO;
            case 'SummaryDocuments': return DocumentType::RESUMEN_DIARIO;
            case 'VoidedDocuments': return $this->fromVoided($doc);
            case 'DespatchAdvice': return DocumentType::GUIA_REMISION;
            case 'Retention': return DocumentType::RETENCION;
            case 'Perception': return DocumentType::PERCEPCION;
            default: return null;
        }
    }

    public function getTypeFromXml(?string $xml): ?string
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml);

        return $this->getType($doc);
    }

    private function fromInvoice(DOMDocument $doc)
    {
        $typeCode = $this->getTextValue($doc, 'cbc:InvoiceTypeCode');

        return $typeCode === DocumentType::BOLETA ? DocumentType::BOLETA : DocumentType::FACTURA;
    }

    private function fromVoided(DOMDocument $doc)
    {
        $id = $this->getTextValue($doc, 'cbc:ID');
        $isReversion = strpos($id, DocumentType::RESUMEN_REVERSION) === 0;

        return $isReversion ? DocumentType::RESUMEN_REVERSION : DocumentType::COMUNICACION_BAJA;
    }

    private function getTextValue(DOMDocument $doc, string $query): ?string
    {
        $xpath = new DOMXPath($doc);
        $node = $xpath->query($query, $doc->documentElement);

        return $node->length > 0 ? $node->item(0)->nodeValue : null;
    }
}

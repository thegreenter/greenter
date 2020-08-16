<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

use DOMDocument;
use DOMXPath;
use Greenter\Validator\Entity\DocumentType;

class XmlTypeResolver implements TypeResolverInterface
{
    public function getType(?string $xml): ?string
    {
        $doc = new DOMDocument();
        $doc->loadXML($xml);

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

    public function fromInvoice(DOMDocument $doc)
    {
        $typeCode = $this->getTextValue($doc, "//*[local-name()='InvoiceTypeCode']");

        return $typeCode === DocumentType::BOLETA ? DocumentType::BOLETA : DocumentType::FACTURA;
    }

    public function fromVoided(DOMDocument $doc)
    {
        $id = $this->getTextValue($doc, "//*[local-name()='ID']");
        $isReversion = strpos($id, DocumentType::RESUMEN_REVERSION) === 0;

        return $isReversion ? DocumentType::RESUMEN_REVERSION : DocumentType::COMUNICACION_BAJA;
    }

    private function getTextValue(DOMDocument $doc, string $query): ?string
    {
        $xpath = new DOMXPath($doc);
        $node = $xpath->query($query);

        return $node->length > 0 ? $node->item(0)->nodeValue : null;
    }
}

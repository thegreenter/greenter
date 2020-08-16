<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

use Greenter\Validator\Entity\DocumentType;

class XslPathResolver implements RuleResolverInterface
{
    /**
     * @var string
     */
    public $basePath;

    /**
     * XslPathResolver constructor.
     * @param string $basePath
     */
    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function getPath(?string $typeDoc): ?string
    {
        switch ($typeDoc) {
            case DocumentType::FACTURA: $xslFile = "2.X/ValidaExprRegFactura-2.0.1.xsl";
                break;
            case DocumentType::BOLETA: $xslFile = "2.X/ValidaExprRegBoleta-2.0.1.xsl";
                break;
            case DocumentType::NOTA_CREDITO: $xslFile = "2.X/ValidaExprRegNC-2.0.1.xsl";
                break;
            case DocumentType::NOTA_DEBITO: $xslFile = "2.X/ValidaExprRegND-2.0.1.xsl";
                break;
            case DocumentType::RESUMEN_DIARIO: $xslFile = "1.X/ValidaExprRegSummary-1.1.0.xsl";
                break;
            case DocumentType::COMUNICACION_BAJA: $xslFile = "1.X/ValidaExprRegSummaryVoided-1.0.1.xsl";
                break;
            case DocumentType::GUIA_REMISION: $xslFile = "2.X/ValidaExprRegGuiaRemitente-2.0.1.xsl";
                break;
            case DocumentType::RETENCION: $xslFile = "1.X/ValidaExprRegRetencion-1.0.3.xsl";
                break;
            case DocumentType::PERCEPCION: $xslFile = "1.X/ValidaExprRegPercepcion-1.0.1.xsl";
                break;
            case DocumentType::RESUMEN_REVERSION: $xslFile = "1.X/ValidaExprRegOtrosVoided-1.0.1.xsl";
                break;
            default:
                return null;
        }

        return $this->basePath.PATH_SEPARATOR.$xslFile;
    }
}

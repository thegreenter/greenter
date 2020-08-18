<?php

declare(strict_types=1);

namespace Greenter\Validator\Resolver;

use Greenter\Validator\Entity\DocumentType;

class XslPathResolver implements RuleResolverInterface
{
    /**
     * @var string
     */
    private $basePath;

    private $pathMapping = [
        DocumentType::FACTURA => "2.X/ValidaExprRegFactura-2.0.1.xsl",
        DocumentType::BOLETA => "2.X/ValidaExprRegBoleta-2.0.1.xsl",
        DocumentType::NOTA_CREDITO => "2.X/ValidaExprRegNC-2.0.1.xsl",
        DocumentType::NOTA_DEBITO => "2.X/ValidaExprRegND-2.0.1.xsl",
        DocumentType::RESUMEN_DIARIO => "1.X/ValidaExprRegSummary-1.1.0.xsl",
        DocumentType::COMUNICACION_BAJA => "1.X/ValidaExprRegSummaryVoided-1.0.1.xsl",
        DocumentType::GUIA_REMISION => "2.X/ValidaExprRegGuiaRemitente-2.0.1.xsl",
        DocumentType::RETENCION => "1.X/ValidaExprRegRetencion-1.0.3.xsl",
        DocumentType::PERCEPCION => "1.X/ValidaExprRegPercepcion-1.0.1.xsl",
        DocumentType::RESUMEN_REVERSION => "1.X/ValidaExprRegOtrosVoided-1.0.1.xsl",
    ];

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
        if (!isset($this->pathMapping[$typeDoc])) {
            return null;
        }

        return $this->basePath.DIRECTORY_SEPARATOR.$this->pathMapping[$typeDoc];
    }
}

<?php

declare(strict_types=1);

namespace Greenter\Validator\Entity;

/**
 * Document Type (Cat. 01)
 *
 * Class DocumentType
 */
class DocumentType
{
    public const FACTURA = '01';
    public const BOLETA = '03';
    public const NOTA_CREDITO = '07';
    public const NOTA_DEBITO = '08';
    public const RESUMEN_DIARIO = 'RC';
    public const COMUNICACION_BAJA = 'RA';
    public const GUIA_REMISION = '09';
    public const RETENCION = '20';
    public const PERCEPCION = '40';
    public const RESUMEN_REVERSION = 'RR';
}

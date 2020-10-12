<?php

declare(strict_types=1);

namespace Greenter\Ws\Services;

/**
 * Class CustomErrorCodes.
 *
 * @internal
 */
final class CustomErrorCodes
{
    public const CDR_NOTFOUND_CODE = 'CDR';
    public const CDR_NOTFOUND_BILL_MSG = 'CDR no encontrado. La respuesta del servicio de SUNAT no incluyó el CDR.';
    public const CDR_NOTFOUND_EXT_MSG = 'CDR no encontrado en código estado: 98 (Procesado).';
}
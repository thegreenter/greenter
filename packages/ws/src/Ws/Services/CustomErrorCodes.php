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

    /**
     * SUNAT rechaza las credenciales inválidas con un HTTP 401 sin sobre SOAP, sin indicar
     * si falló el usuario o la clave; se reporta como 0102 (catálogo de errores de SUNAT).
     */
    public const UNAUTHORIZED_CODE = '0102';
    public const UNAUTHORIZED_MSG = 'Usuario o contraseña incorrectos (HTTP 401 Unauthorized).';
}
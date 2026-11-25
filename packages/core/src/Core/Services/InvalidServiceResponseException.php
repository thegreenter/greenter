<?php

declare(strict_types=1);

namespace Greenter\Services;

use Greenter\Exception\GreenterException;
use LogicException;

/**
 * Respuesta de un servicio con formato inesperado.
 */
class InvalidServiceResponseException extends LogicException implements GreenterException
{
}
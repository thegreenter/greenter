<?php

declare(strict_types=1);

namespace Greenter\Ws\Builder;

use Greenter\Exception\GreenterException;
use LogicException;

/**
 * Tipo de documento o servicio no soportado.
 */
class DocumentNoSupportException extends LogicException implements GreenterException
{

}
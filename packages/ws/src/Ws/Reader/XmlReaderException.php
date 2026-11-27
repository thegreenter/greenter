<?php

declare(strict_types=1);

namespace Greenter\Ws\Reader;

use Greenter\Exception\GreenterException;
use LogicException;

/**
 * XML inválido o no soportado.
 */
class XmlReaderException extends LogicException implements GreenterException
{

}
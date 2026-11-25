<?php

declare(strict_types=1);

namespace Greenter\Report\Resolver;

use Greenter\Exception\GreenterException;
use LogicException;

/**
 * Documento sin plantilla de reporte.
 */
class InvalidDocumentException extends LogicException implements GreenterException
{

}
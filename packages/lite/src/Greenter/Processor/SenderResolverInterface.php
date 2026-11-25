<?php

declare(strict_types=1);

namespace Greenter\Processor;

use Greenter\Services\SenderInterface;

/**
 * Obtiene el servicio de envío de un tipo de documento.
 */
interface SenderResolverInterface
{
    /**
     * @param string $docClass Clase del documento (o una subclase)
     */
    public function find(string $docClass): SenderInterface;
}

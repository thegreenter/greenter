<?php

declare(strict_types=1);

namespace Greenter\Processor;

use Greenter\Builder\BuilderInterface;
use Greenter\Exception\GreenterException;

/**
 * Obtiene el builder XML de un tipo de documento.
 */
interface BuilderResolverInterface
{
    /**
     * @param string $docClass Clase del documento (o una subclase)
     *
     * @throws GreenterException Si el documento no tiene builder
     */
    public function find(string $docClass): BuilderInterface;
}

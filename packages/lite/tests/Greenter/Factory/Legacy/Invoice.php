<?php

declare(strict_types=1);

namespace Tests\Greenter\Factory\Legacy;

use Greenter\Model\DocumentInterface;

/**
 * Documento propio que no extiende de Greenter\Model\Sale\Invoice, pero con el mismo nombre corto.
 */
class Invoice implements DocumentInterface
{
    public function getName(): string
    {
        return 'legacy';
    }
}

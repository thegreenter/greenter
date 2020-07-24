<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:09
 */

declare(strict_types=1);

namespace Greenter\Data;

use Greenter\Model\DocumentInterface;

interface DocumentGeneratorInterface
{
    /**
     * @return DocumentInterface
     */
    public function create(): ?DocumentInterface;
}

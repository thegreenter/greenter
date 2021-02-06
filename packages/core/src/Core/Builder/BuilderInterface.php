<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:26.
 */

declare(strict_types=1);

namespace Greenter\Builder;

use Greenter\Model\DocumentInterface;

/**
 * Interface BuilderInterface.
 */
interface BuilderInterface
{
    /**
     * Create file for document.
     *
     * @param DocumentInterface $document
     *
     * @return string|null Content File
     */
    public function build(DocumentInterface $document): ?string;
}

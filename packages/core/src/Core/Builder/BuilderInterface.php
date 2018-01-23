<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:26.
 */

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
     * @return string Content File
     */
    public function build(DocumentInterface $document);
}

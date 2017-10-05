<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:26
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\DocumentInterface;

/**
 * Interface BuilderInterface
 * @package Greenter\Xml\Builder
 */
interface BuilderInterface
{
    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     * @return string
     */
    public function build(DocumentInterface $document);
}
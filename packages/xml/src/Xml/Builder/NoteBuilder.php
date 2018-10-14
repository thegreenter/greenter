<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:43
 */

namespace Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;

/**
 * Class NoteBuilder
 * @package Greenter\Xml\Builder
 */
class NoteBuilder extends TwigBuilder implements BuilderInterface
{
    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     * @return string
     */
    public function build(DocumentInterface $document)
    {
        /**@var $document \Greenter\Model\Sale\Note */
        $prefix = $document->getTipoDoc() === '07' ? 'notacr' : 'notadb';
        $template = $prefix.$document->getUblVersion().'.xml.twig';

        return $this->render($template, $document);
    }
}
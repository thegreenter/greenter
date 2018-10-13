<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 5/10/2018
 * Time: 13:53.
 */

namespace Greenter\Xml\Builder\v21;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Xml\Builder\TwigBuilder;

/**
 * Class NoteBuilder.
 */
class NoteBuilder extends TwigBuilder implements BuilderInterface
{
    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     *
     * @return string
     */
    public function build(DocumentInterface $document)
    {
        /**@var $document \Greenter\Model\Sale\Note */
        $template = $document->getTipoDoc() === '07'
            ? 'notacr.21.xml.twig' : 'notadb.21.xml.twig';

        return $this->render($template, $document);
    }
}

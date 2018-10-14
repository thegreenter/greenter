<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:37
 */

namespace Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;

/**
 * Class InvoiceBuilder
 * @package Greenter\Xml\Builder
 */
class InvoiceBuilder extends TwigBuilder implements BuilderInterface
{

    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     * @return string
     * @throws \Exception
     */
    public function build(DocumentInterface $document)
    {
        /**@var $document Invoice */
        $template = 'invoice'.$document->getUblVersion().'.xml.twig';

        return $this->render($template, $document);
    }
}
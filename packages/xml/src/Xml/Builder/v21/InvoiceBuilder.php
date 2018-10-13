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
 * Class InvoiceBuilder.
 */
class InvoiceBuilder extends TwigBuilder implements BuilderInterface
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
        return $this->render('invoice.21.xml.twig', $document);
    }
}

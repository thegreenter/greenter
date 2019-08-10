<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:37.
 */

namespace Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;
use Greenter\Xml\Filter\TributoFunction;
use Twig\TwigFunction;

/**
 * Class InvoiceBuilder.
 */
class InvoiceBuilder extends TwigBuilder implements BuilderInterface
{
    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        parent::__construct($options);

        $this->twig->addFunction(new TwigFunction('getTributoAfect', [TributoFunction::class, 'getByAfectacion']));
    }

    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     *
     * @return string
     *
     * @throws \Exception
     */
    public function build(DocumentInterface $document)
    {
        /** @var $document Invoice */
        $template = 'invoice'.$document->getUblVersion().'.xml.twig';

        return $this->render($template, $document);
    }
}

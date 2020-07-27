<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:37.
 */

declare(strict_types=1);

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
    public function build(DocumentInterface $document): ?string
    {
        /** @var Invoice $invoice */
        $invoice = /*.(Invoice).*/ $document;
        $template = 'invoice'.$invoice->getUblVersion().'.xml.twig';

        return $this->render($template, $document);
    }
}

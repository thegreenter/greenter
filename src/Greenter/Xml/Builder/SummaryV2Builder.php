<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:39 PM
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\DocumentInterface;

/**
 * Class SummaryV2Builder
 * @package Greenter\Xml\Builder
 */
class SummaryV2Builder extends TwigBuilder implements BuilderInterface
{
    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     * @return string
     */
    public function build(DocumentInterface $document)
    {
        return $this->render('summary-v2.xml.twig', $document);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:46
 */

declare(strict_types=1);

namespace Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;

/**
 * Class DespatchBuilder
 * @package Greenter\Xml\Builder
 */
class DespatchBuilder extends TwigBuilder implements BuilderInterface
{
    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     * @return string
     */
    public function build(DocumentInterface $document): ?string
    {
        /** @var Despatch $despatch */
        $despatch = $document;
        $template = $despatch->getVersion() === '2022' ? 'despatch2022.xml.twig': 'despatch.xml.twig';

        return $this->render($template, $document);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/02/2019
 * Time: 21:25.
 */

namespace Greenter\Report\Resolver;

use Greenter\Model\DocumentInterface;

class DefaultTemplateResolver implements TemplateResolverInterface
{
    /**
     * @param DocumentInterface $document
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getTemplate($document)
    {
        $className = get_class($document);
        switch ($className) {
            case \Greenter\Model\Sale\Invoice::class:
            case \Greenter\Model\Sale\Note::class:
                $name = 'invoice';
                break;
            case \Greenter\Model\Retention\Retention::class:
                $name = 'retention';
                break;
            case \Greenter\Model\Perception\Perception::class:
                $name = 'perception';
                break;
            case \Greenter\Model\Despatch\Despatch::class:
                $name = 'despatch';
                break;
            case \Greenter\Model\Summary\Summary::class:
                $name = 'summary';
                break;
            case \Greenter\Model\Voided\Voided::class:
            case \Greenter\Model\Voided\Reversion::class:
                $name = 'voided';
                break;
            default:
                throw new \Exception('Not found template for '.$className);
        }

        return $name.'.html.twig';
    }
}

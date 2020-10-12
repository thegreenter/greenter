<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/02/2019
 * Time: 21:25.
 */

namespace Greenter\Report\Resolver;

use Exception;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;

class DefaultTemplateResolver implements TemplateResolverInterface
{
    /**
     * @param DocumentInterface $document
     *
     * @return string
     *
     * @throws Exception
     */
    public function getTemplate(DocumentInterface $document): ?string
    {
        $className = get_class($document);
        switch ($className) {
            case Invoice::class:
            case Note::class:
                $name = 'invoice';
                break;
            case Retention::class:
                $name = 'retention';
                break;
            case Perception::class:
                $name = 'perception';
                break;
            case Despatch::class:
                $name = 'despatch';
                break;
            case Summary::class:
                $name = 'summary';
                break;
            case Voided::class:
            case Reversion::class:
                $name = 'voided';
                break;
            default:
                throw new InvalidDocumentException('Not found template for '.$className);
        }

        return $name.'.html.twig';
    }
}

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
     * Plantilla por tipo de documento (incluye sus subclases).
     */
    private const TEMPLATES = [
        Invoice::class => 'invoice',
        Note::class => 'invoice',
        Retention::class => 'retention',
        Perception::class => 'perception',
        Despatch::class => 'despatch',
        Summary::class => 'summary',
        Voided::class => 'voided',
        Reversion::class => 'voided',
    ];

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
        $classes = array_merge([$className], array_values(class_parents($document)));

        foreach ($classes as $class) {
            if (isset(self::TEMPLATES[$class])) {
                return self::TEMPLATES[$class].'.html.twig';
            }
        }

        throw new InvalidDocumentException('Not found template for '.$className);
    }
}

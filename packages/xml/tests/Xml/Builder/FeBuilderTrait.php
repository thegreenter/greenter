<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:40 AM.
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\VoidedBuilder;

/**
 * Trait FeBuilderTrait.
 */
trait FeBuilderTrait
{
    use SharedBuilderTrait;

    private $builders = [
        Invoice::class => InvoiceBuilder::class,
        Note::class => NoteBuilder::class,
        Summary::class => SummaryBuilder::class,
        Voided::class => VoidedBuilder::class,
    ];

    /**
     * @param $className
     *
     * @return BuilderInterface
     */
    private function getGenerator($className)
    {
        $builderClass = $this->builders[$className];
        $builder = new $builderClass([
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ]);

        /** @var BuilderInterface $builder */
        return $builder;
    }

    private function build(DocumentInterface $document): ?string
    {
        $generator = $this->getGenerator(get_class($document));

        return $generator->build($document);
    }
}

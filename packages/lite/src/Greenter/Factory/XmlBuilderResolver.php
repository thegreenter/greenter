<?php

declare(strict_types=1);

namespace Greenter\Factory;

use Greenter\Builder\BuilderInterface;

class XmlBuilderResolver
{
    /**
     * @var string[]
     */
    private $builders;
    /**
     * @var array
     */
    private $options;

    /**
     * XmlBuilderResolver constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->builders = [
            \Greenter\Model\Sale\Invoice::class => \Greenter\Xml\Builder\InvoiceBuilder::class,
            \Greenter\Model\Sale\Note::class => \Greenter\Xml\Builder\NoteBuilder::class,
            \Greenter\Model\Summary\Summary::class => \Greenter\Xml\Builder\SummaryBuilder::class,
            \Greenter\Model\Voided\Voided::class => \Greenter\Xml\Builder\VoidedBuilder::class,
            \Greenter\Model\Despatch\Despatch::class => \Greenter\Xml\Builder\DespatchBuilder::class,
            \Greenter\Model\Retention\Retention::class => \Greenter\Xml\Builder\RetentionBuilder::class,
            \Greenter\Model\Perception\Perception::class => \Greenter\Xml\Builder\PerceptionBuilder::class,
            \Greenter\Model\Voided\Reversion::class => \Greenter\Xml\Builder\VoidedBuilder::class,
        ];
    }

    public function find(string $docClass): BuilderInterface
    {
        $builder = $this->builders[$docClass];

        return new $builder($this->options);
    }
}

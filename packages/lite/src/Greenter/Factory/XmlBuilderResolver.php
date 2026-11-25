<?php

declare(strict_types=1);

namespace Greenter\Factory;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Ws\Builder\DocumentNoSupportException;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\VoidedBuilder;

class XmlBuilderResolver
{
    /**
     * Builders por defecto (Reversion usa VoidedBuilder por herencia).
     */
    private const DEFAULT_BUILDERS = [
        Invoice::class => InvoiceBuilder::class,
        Note::class => NoteBuilder::class,
        Summary::class => SummaryBuilder::class,
        Voided::class => VoidedBuilder::class,
        Despatch::class => DespatchBuilder::class,
        Perception::class => PerceptionBuilder::class,
        Retention::class => RetentionBuilder::class,
    ];

    /**
     * @var array
     */
    private $options;

    /**
     * @var array<string, string> Clase del documento => clase del builder
     */
    private $builders;

    /**
     * @var array<string, BuilderInterface> Clase del builder => instancia
     */
    private $instances = [];

    /**
     * XmlBuilderResolver constructor.
     *
     * @param array $options  Twig options
     * @param array<string, string> $builders Builders adicionales: clase del documento => clase del builder
     */
    public function __construct(array $options = [], array $builders = [])
    {
        $this->options = $options;
        $this->builders = array_merge(self::DEFAULT_BUILDERS, $builders);
    }

    /**
     * Registra el builder para un tipo de documento (y sus subclases).
     *
     * @param string $docClass     Clase que implementa DocumentInterface
     * @param string $builderClass Clase que implementa BuilderInterface, recibe las opciones en su constructor
     *
     * @return $this
     */
    public function register(string $docClass, string $builderClass): self
    {
        $this->builders[$docClass] = $builderClass;

        return $this;
    }

    /**
     * Cambia las opciones de los builders, descarta las instancias creadas.
     *
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
        $this->instances = [];
    }

    /**
     * Obtiene el builder del documento, la instancia se reutiliza entre llamadas.
     *
     * @param string $docClass
     *
     * @return BuilderInterface
     */
    public function find(string $docClass): BuilderInterface
    {
        $builder = $this->findBuilderType($docClass);

        if (!isset($this->instances[$builder])) {
            $this->instances[$builder] = new $builder($this->options);
        }

        return $this->instances[$builder];
    }

    private function findBuilderType(string $docClass): string
    {
        foreach ($this->getHierarchy($docClass) as $class) {
            if (isset($this->builders[$class])) {
                return $this->builders[$class];
            }
        }

        // Convención anterior: Greenter\Xml\Builder\{Documento}Builder
        $className = substr((string)strrchr('\\'.$docClass, '\\'), 1);
        $builder = 'Greenter\\Xml\\Builder\\'.$className.'Builder';
        if (class_exists($builder)) {
            return $builder;
        }

        throw new DocumentNoSupportException('No existe un XML builder para '.$docClass);
    }

    /**
     * @return string[] La clase y sus clases padre, de la más específica a la más general.
     */
    private function getHierarchy(string $docClass): array
    {
        if (!class_exists($docClass)) {
            return [$docClass];
        }

        return array_merge([$docClass], array_values(class_parents($docClass)));
    }
}

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

    /**
     * Verifica que el TaxAmount de los tributos sin monto (EXP, EXO, INA) tenga formato n(12,2).
     *
     * @param string $xml
     * @param int $expectedCount
     */
    private function assertZeroTaxAmountFormat(string $xml, int $expectedCount): void
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');

        $nodes = $xpath->query('/*/cac:TaxTotal/cac:TaxSubtotal[cac:TaxCategory/cac:TaxScheme/cbc:ID[.="9995" or .="9997" or .="9998"]]/cbc:TaxAmount');

        $this->assertSame($expectedCount, $nodes->length);
        foreach ($nodes as $node) {
            $this->assertSame('0.00', $node->nodeValue);
        }
    }
}

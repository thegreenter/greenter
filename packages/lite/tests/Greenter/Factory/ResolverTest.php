<?php

declare(strict_types=1);

namespace Tests\Greenter\Factory;

use Greenter\Builder\BuilderInterface;
use Greenter\Factory\WsSenderResolver;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Ws\Builder\DocumentNoSupportException;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\WsClientInterface;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\VoidedBuilder;
use PHPUnit\Framework\TestCase;

class ResolverTest extends TestCase
{
    /**
     * @dataProvider builderProvider
     */
    public function testFindBuilder(string $docClass, string $builderClass): void
    {
        $resolver = new XmlBuilderResolver();

        $this->assertInstanceOf($builderClass, $resolver->find($docClass));
    }

    public function builderProvider(): array
    {
        return [
            [Invoice::class, InvoiceBuilder::class],
            [Note::class, NoteBuilder::class],
            [Summary::class, SummaryBuilder::class],
            [Voided::class, VoidedBuilder::class],
            [Reversion::class, VoidedBuilder::class],
            [Despatch::class, DespatchBuilder::class],
            [Perception::class, PerceptionBuilder::class],
            [Retention::class, RetentionBuilder::class],
            'subclase de Invoice' => [CustomInvoice::class, InvoiceBuilder::class],
            'subclase de Summary' => [CustomSummary::class, SummaryBuilder::class],
        ];
    }

    public function testReuseBuilderInstance(): void
    {
        $resolver = new XmlBuilderResolver(['cache' => false]);
        $builder = $resolver->find(Invoice::class);

        $this->assertSame($builder, $resolver->find(Invoice::class));
        $this->assertSame($builder, $resolver->find(CustomInvoice::class));

        $resolver->setOptions(['cache' => false, 'strict_variables' => true]);
        $this->assertNotSame($builder, $resolver->find(Invoice::class));
    }

    public function testRegisterCustomBuilder(): void
    {
        $resolver = new XmlBuilderResolver([], [CustomDocument::class => CustomBuilder::class]);
        $this->assertInstanceOf(CustomBuilder::class, $resolver->find(CustomDocument::class));

        $resolver->register(CustomInvoice::class, CustomBuilder::class);
        $this->assertInstanceOf(CustomBuilder::class, $resolver->find(CustomInvoice::class));
        $this->assertInstanceOf(InvoiceBuilder::class, $resolver->find(Invoice::class));
    }

    public function testBuilderNotFound(): void
    {
        $this->expectException(DocumentNoSupportException::class);

        (new XmlBuilderResolver())->find(CustomDocument::class);
    }

    /**
     * @dataProvider senderProvider
     */
    public function testFindSender(string $docClass, string $senderClass): void
    {
        $resolver = new WsSenderResolver($this->createMock(WsClientInterface::class), null);

        $this->assertInstanceOf($senderClass, $resolver->find($docClass));
    }

    public function senderProvider(): array
    {
        return [
            [Invoice::class, BillSender::class],
            [CustomInvoice::class, BillSender::class],
            [Summary::class, SummarySender::class],
            [CustomSummary::class, SummarySender::class],
            [Voided::class, SummarySender::class],
            [Reversion::class, SummarySender::class],
        ];
    }
}

class CustomInvoice extends Invoice
{
}

class CustomSummary extends Summary
{
}

class CustomDocument implements DocumentInterface
{
    public function getName(): string
    {
        return 'custom';
    }
}

class CustomBuilder implements BuilderInterface
{
    public function __construct(array $options = [])
    {
    }

    public function build(DocumentInterface $document): ?string
    {
        return '<custom/>';
    }
}

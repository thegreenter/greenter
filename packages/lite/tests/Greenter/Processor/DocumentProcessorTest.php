<?php

declare(strict_types=1);

namespace Tests\Greenter\Processor;

use Greenter\Builder\BuilderInterface;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Data\GeneratorFactory;
use Greenter\Exception\GreenterException;
use Greenter\Factory\WsSenderResolver;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Summary\Summary;
use Greenter\Processor\BuilderResolverInterface;
use Greenter\Processor\DocumentProcessor;
use Greenter\Processor\SenderResolverInterface;
use Greenter\Processor\SignedXmlSigner;
use Greenter\Processor\XmlSignerInterface;
use Greenter\Services\SenderInterface;
use Greenter\Ws\Services\WsClientInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class DocumentProcessorTest extends TestCase
{
    public function testBuildAndSign(): void
    {
        $processor = new DocumentProcessor(
            new XmlBuilderResolver(['cache' => false]),
            SignedXmlSigner::fromCertificate((string)file_get_contents(__DIR__.'/../../Resources/SFSCert.pem')),
            $this->createMock(SenderResolverInterface::class)
        );
        $invoice = $this->createInvoice();

        $xml = $processor->build($invoice);
        $signed = $processor->getXmlSigned($invoice);

        $this->assertStringStartsWith('<?xml', $xml);
        $this->assertStringNotContainsString('<ds:Signature', $xml);
        $this->assertStringContainsString('<ds:Signature Id="GreenterSign"', $signed);
    }

    public function testSendUsesSenderOfDocumentClass(): void
    {
        $invoice = $this->createInvoice();
        $sender = $this->createMock(SenderInterface::class);
        $sender->expects($this->once())
            ->method('send')
            ->with($invoice->getName(), 'XML-FIRMADO')
            ->willReturn((new SummaryResult())->setSuccess(true));
        $senders = $this->createMock(SenderResolverInterface::class);
        $senders->expects($this->once())
            ->method('find')
            ->with(Invoice::class)
            ->willReturn($sender);

        $result = $this->createProcessor($senders)->send($invoice);

        $this->assertTrue($result->isSuccess());
    }

    public function testSendXmlWithSoapSenders(): void
    {
        $response = new stdClass();
        $response->ticket = '123456';
        $client = $this->createMock(WsClientInterface::class);
        $client->expects($this->once())
            ->method('call')
            ->with('sendSummary', $this->anything())
            ->willReturn($response);

        /** @var SummaryResult $result */
        $result = $this->createProcessor(new WsSenderResolver($client))
            ->sendXml(Summary::class, '20123456789-RC-20261125-1', '<SummaryDocuments/>');

        $this->assertTrue($result->isSuccess());
        $this->assertSame('123456', $result->getTicket());
    }

    public function testSameProcessorForManyDocuments(): void
    {
        $processor = new DocumentProcessor(
            new XmlBuilderResolver(['cache' => false]),
            $this->createSigner(),
            $this->createMock(SenderResolverInterface::class)
        );
        $summary = (new GeneratorFactory())->create(SummaryStore::class)->create();

        $this->assertStringContainsString('<SummaryDocuments', $processor->getXmlSigned($summary));
        $this->assertStringContainsString('<Invoice', $processor->getXmlSigned($this->createInvoice()));
    }

    public function testUnsupportedDocument(): void
    {
        $processor = new DocumentProcessor(
            new XmlBuilderResolver(),
            $this->createSigner(),
            $this->createMock(SenderResolverInterface::class)
        );

        $this->expectException(GreenterException::class);
        $processor->build($this->createMock(DocumentInterface::class));
    }

    private function createProcessor(SenderResolverInterface $senders): DocumentProcessor
    {
        $builder = $this->createMock(BuilderInterface::class);
        $builder->method('build')->willReturn('XML');
        $builders = $this->createMock(BuilderResolverInterface::class);
        $builders->method('find')->willReturn($builder);
        $signer = $this->createMock(XmlSignerInterface::class);
        $signer->method('signXml')->with('XML')->willReturn('XML-FIRMADO');

        return new DocumentProcessor($builders, $signer, $senders);
    }

    private function createSigner(): XmlSignerInterface
    {
        $signer = $this->createMock(XmlSignerInterface::class);
        $signer->method('signXml')->willReturnArgument(0);

        return $signer;
    }

    private function createInvoice(): Invoice
    {
        /** @var Invoice $invoice */
        $invoice = (new GeneratorFactory())->create(InvoiceFullStore::class)->create();
        $invoice->setUblVersion('2.1');

        return $invoice;
    }
}

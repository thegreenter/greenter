<?php

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\Api;
use Greenter\Api\ApiFactory;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\GeneratorFactory;
use Greenter\Factory\FeFactory;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Summary\Summary;
use Greenter\See;
use Greenter\Sunat\GRE\Api\CpeApiInterface;
use Greenter\Sunat\GRE\Model\CpeResponse;
use Greenter\Sunat\GRE\Model\StatusResponse;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Builder\DocumentNoSupportException;
use Greenter\Ws\Reader\XmlReaderException;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SummarySender;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * See y Api como fachadas de DocumentProcessor (sin conexión a SUNAT).
 */
class SeeProcessorTest extends TestCase
{
    public function testSeeLastXml(): void
    {
        $see = $this->createSee($this->createMock(SoapClient::class));

        $this->assertNull($see->getLastXml());
        $xml = $see->getXmlSigned($this->createInvoice());

        $this->assertStringContainsString('<ds:Signature Id="GreenterSign"', (string)$xml);
        $this->assertSame($xml, $see->getLastXml());
    }

    public function testSeeFactoryIsDeprecatedButSynchronized(): void
    {
        $response = new stdClass();
        $response->ticket = '123';
        $client = $this->createMock(SoapClient::class);
        $client->method('call')->willReturn($response);
        $see = $this->createSee($client);

        $deprecations = [];
        set_error_handler(function (int $type, string $message) use (&$deprecations): bool {
            $deprecations[] = $message;

            return true;
        }, E_USER_DEPRECATED);
        try {
            $xml = $see->getXmlSigned($this->createInvoice());
            $see->sendXml(Summary::class, '20123456789-RC-20261125-1', '<SummaryDocuments/>');
            $factory = $see->getFactory();
        } finally {
            restore_error_handler();
        }

        $this->assertInstanceOf(FeFactory::class, $factory);
        $this->assertSame($xml, $factory->getLastXml());
        $this->assertInstanceOf(SummarySender::class, $factory->getSender());
        $this->assertCount(1, $deprecations);
        $this->assertStringContainsString('See::getLastXml()', $deprecations[0]);
    }

    public function testSeeProcessorIsReused(): void
    {
        $see = new See();
        $processor = $see->getProcessor();

        $this->assertSame($processor, $see->getProcessor());
        $see->setCodeProvider($this->createMock(ErrorCodeProviderInterface::class));
        $this->assertNotSame($processor, $see->getProcessor());
    }

    public function testSeeSendXmlUsesSummaryService(): void
    {
        $response = new stdClass();
        $response->ticket = '1700000000001';
        $client = $this->createMock(SoapClient::class);
        $client->expects($this->once())
            ->method('call')
            ->with('sendSummary', $this->anything())
            ->willReturn($response);

        /** @var SummaryResult $result */
        $result = $this->createSee($client)->sendXml(Summary::class, '20123456789-RC-20261125-1', '<SummaryDocuments/>');

        $this->assertTrue($result->isSuccess());
        $this->assertSame('1700000000001', $result->getTicket());
    }

    public function testSeeSendXmlUnsupportedType(): void
    {
        $this->expectException(DocumentNoSupportException::class);

        (new See())->sendXml(stdClass::class, 'name', '<xml/>');
    }

    /**
     * @dataProvider invalidXmlProvider
     */
    public function testSeeSendXmlFileInvalid(string $xml, string $exception): void
    {
        $this->expectException($exception);

        (new See($this->createMock(SoapClient::class)))->sendXmlFile($xml);
    }

    public function invalidXmlProvider(): array
    {
        return [
            'vacío' => ['', XmlReaderException::class],
            'no es XML' => ['texto', XmlReaderException::class],
            'no es comprobante' => ['<Order/>', DocumentNoSupportException::class],
        ];
    }

    public function testApiProcessorResetsWithCredentials(): void
    {
        $factory = $this->createMock(ApiFactory::class);
        $factory->expects($this->once())
            ->method('create')
            ->with('client', 'secret', '20123456789USER', 'PASS')
            ->willReturn($this->createCpeApi());

        $api = new Api(null, $factory, new SignedXml());
        $processor = $api->getProcessor();
        $this->assertSame($processor, $api->getProcessor());

        $api->setApiCredentials('client', 'secret')->setClaveSOL('20123456789', 'USER', 'PASS');
        $this->assertNotSame($processor, $api->getProcessor());

        /** @var SummaryResult $result */
        $result = $api->sendXml('20123456789-09-T001-1', '<DespatchAdvice/>');
        $this->assertSame('TICKET-1', $result->getTicket());
    }

    public function testApiGetStatus(): void
    {
        $factory = $this->createMock(ApiFactory::class);
        $factory->method('create')->willReturn($this->createCpeApi());

        $result = (new Api(null, $factory, new SignedXml()))->getStatus('TICKET-1');

        $this->assertSame('98', $result->getCode());
        $this->assertFalse($result->isSuccess());
    }

    private function createCpeApi(): CpeApiInterface
    {
        $cpeApi = $this->createMock(CpeApiInterface::class);
        $cpeApi->method('enviarCpe')->willReturn((new CpeResponse())->setNumTicket('TICKET-1'));
        $cpeApi->method('consultarEnvio')->with('TICKET-1')->willReturn((new StatusResponse())->setCodRespuesta('98'));

        return $cpeApi;
    }

    private function createSee(SoapClient $client): See
    {
        $signer = new SignedXml();
        $signer->setCertificateFromFile(__DIR__.'/../Resources/SFSCert.pem');
        $see = new See($client, $signer);
        $see->setBuilderOptions(['cache' => false]);

        return $see;
    }

    private function createInvoice(): Invoice
    {
        /** @var Invoice $invoice */
        $invoice = (new GeneratorFactory())->create(InvoiceFullStore::class)->create();
        $invoice->setUblVersion('2.1');

        return $invoice;
    }
}

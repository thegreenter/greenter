<?php

declare(strict_types=1);

namespace Tests\Greenter;

use Greenter\Api;
use Greenter\Api\ApiFactory;
use Greenter\Data\Generator\Despatch2022Store;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\GeneratorFactory;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Invoice;
use Greenter\See;
use Greenter\Sunat\GRE\Api\CpeApiInterface;
use Greenter\Sunat\GRE\Model\CpeResponse;
use Greenter\Ws\Services\SoapClient;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use PHPUnit\Framework\TestCase;
use SoapFault;

/**
 * See y Api reutilizan los builders de su XmlBuilderResolver (sin conexión a SUNAT).
 */
class BuilderResolverUsageTest extends TestCase
{
    public function testSeeGetXmlSignedReusesBuilder(): void
    {
        $see = $this->createSee(new SoapClient());
        $invoice = $this->createInvoice();

        $xml = $see->getXmlSigned($invoice);
        $builder = $see->getBuilderResolver()->find(Invoice::class);
        $see->getXmlSigned($invoice);

        $this->assertStringContainsString('<ds:Signature Id="GreenterSign"', (string)$xml);
        $this->assertSame($builder, $see->getBuilderResolver()->find(Invoice::class));
    }

    public function testSeeOptionsResetBuilders(): void
    {
        $see = new See();
        $builder = $see->getBuilderResolver()->find(Invoice::class);

        $see->setCachePath(null);
        $other = $see->getBuilderResolver()->find(Invoice::class);
        $see->setBuilderOptions(['strict_variables' => true]);

        $this->assertNotSame($builder, $other);
        $this->assertNotSame($other, $see->getBuilderResolver()->find(Invoice::class));
    }

    public function testSeeSendUsesInjectedClient(): void
    {
        $client = $this->createMock(SoapClient::class);
        $client->expects($this->once())
            ->method('call')
            ->with('sendBill', $this->anything())
            ->willThrowException(new SoapFault('soap:Client', 'Error de prueba'));

        /** @var BillResult $result */
        $result = $this->createSee($client)->send($this->createInvoice());

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
    }

    public function testApiSendUsesBuilderResolver(): void
    {
        $cpeApi = $this->createMock(CpeApiInterface::class);
        $cpeApi->method('enviarCpe')->willReturn((new CpeResponse())->setNumTicket('TICKET-1'));
        $factory = $this->createMock(ApiFactory::class);
        $factory->method('create')->willReturn($cpeApi);
        $signer = new SignedXml();
        $signer->setCertificateFromFile($this->getCertificatePath());

        $api = (new Api(null, $factory, $signer))
            ->setBuilderOptions(['cache' => false])
            ->setApiCredentials('client', 'secret')
            ->setClaveSOL('20123456789', 'USER', 'PASS');
        $despatch = (new GeneratorFactory())->create(Despatch2022Store::class)->create();

        /** @var SummaryResult $result */
        $result = $api->send($despatch);

        $this->assertTrue($result->isSuccess());
        $this->assertSame('TICKET-1', $result->getTicket());
        $this->assertStringContainsString('<ds:Signature Id="GreenterSign"', (string)$api->getLastXml());
    }

    private function createSee(SoapClient $client): See
    {
        $see = new See($client);
        $see->setBuilderOptions(['cache' => false]);
        $see->setCertificate((string)file_get_contents($this->getCertificatePath()));
        $see->setClaveSOL('20123456789', 'MODDATOS', 'moddatos');

        return $see;
    }

    private function createInvoice(): Invoice
    {
        /** @var Invoice $invoice */
        $invoice = (new GeneratorFactory())->create(InvoiceFullStore::class)->create();
        $invoice->setUblVersion('2.1');

        return $invoice;
    }

    private function getCertificatePath(): string
    {
        return __DIR__.'/../Resources/SFSCert.pem';
    }
}

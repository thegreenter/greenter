<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Ws\Reader\CdrReaderInterface;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\WsClientInterface;
use Greenter\Zip\CompressInterface;
use Greenter\Zip\DecompressInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Dependencias de BaseSunat por setters; las propiedades públicas anteriores siguen funcionando (deprecadas).
 */
class BaseSunatDependenciesTest extends TestCase
{
    /**
     * @var string[]
     */
    private $deprecations = [];

    protected function setUp(): void
    {
        $this->deprecations = [];
        set_error_handler(function (int $type, string $message): bool {
            $this->deprecations[] = $message;

            return true;
        }, E_USER_DEPRECATED);
    }

    protected function tearDown(): void
    {
        restore_error_handler();
    }

    public function testSetters(): void
    {
        $sender = new BillSender();
        $result = $sender
            ->setCompressor($this->createCompressor())
            ->setDecompressor($this->createDecompressor())
            ->setCdrReader($this->createCdrReader())
            ->setClient($this->createClient())
            ->send('20123456789-01-F001-1', '<Invoice/>');

        $this->assertSendResult($result);
        $this->assertSame([], $this->deprecations);
    }

    public function testDeprecatedPublicProperties(): void
    {
        $sender = new BillSender();
        $compressor = $this->createCompressor();

        $this->assertFalse(isset($sender->compressor));
        $sender->compressor = $compressor;
        $sender->decompressor = $this->createDecompressor();
        $sender->cdrReader = $this->createCdrReader();
        $sender->setClient($this->createClient());

        $this->assertTrue(isset($sender->compressor));
        $this->assertSame($compressor, $sender->compressor);
        $this->assertSendResult($sender->send('20123456789-01-F001-1', '<Invoice/>'));
        $this->assertCount(4, $this->deprecations);
        $this->assertStringContainsString('setCompressor()', $this->deprecations[0]);
    }

    public function testDynamicProperties(): void
    {
        $sender = new BillSender();
        $sender->custom = 'valor';

        $this->assertSame('valor', $sender->custom);
        $this->assertFalse(isset($sender->other));
        $this->assertSame([], $this->deprecations);
    }

    public function testUndefinedProperty(): void
    {
        $warnings = [];
        set_error_handler(function (int $type, string $message) use (&$warnings): bool {
            $warnings[] = $message;

            return true;
        }, E_USER_WARNING);

        try {
            $value = (new BillSender())->other;
        } finally {
            restore_error_handler();
        }

        $this->assertNull($value);
        $this->assertSame(['Undefined property: '.BillSender::class.'::$other'], $warnings);
    }

    private function assertSendResult($result): void
    {
        /** @var BillResult $result */
        $this->assertTrue($result->isSuccess());
        $this->assertSame('0', $result->getCdrResponse()->getCode());
        $this->assertSame('CDR-ZIP', $result->getCdrZip());
    }

    private function createCompressor(): CompressInterface
    {
        $compressor = $this->createMock(CompressInterface::class);
        $compressor->expects($this->once())
            ->method('compress')
            ->with('20123456789-01-F001-1.xml', '<Invoice/>')
            ->willReturn('XML-ZIP');

        return $compressor;
    }

    private function createDecompressor(): DecompressInterface
    {
        $decompressor = $this->createMock(DecompressInterface::class);
        $decompressor->expects($this->once())
            ->method('decompress')
            ->with('CDR-ZIP', $this->isType('callable'))
            ->willReturn([['filename' => 'R-20123456789-01-F001-1.xml', 'content' => '<CDR/>']]);

        return $decompressor;
    }

    private function createCdrReader(): CdrReaderInterface
    {
        $reader = $this->createMock(CdrReaderInterface::class);
        $reader->expects($this->once())
            ->method('getCdrResponse')
            ->with('<CDR/>')
            ->willReturn((new CdrResponse())->setCode('0'));

        return $reader;
    }

    private function createClient(): WsClientInterface
    {
        $response = new stdClass();
        $response->applicationResponse = 'CDR-ZIP';

        $client = $this->createMock(WsClientInterface::class);
        $client->expects($this->once())
            ->method('call')
            ->with('sendBill', ['parameters' => ['fileName' => '20123456789-01-F001-1.zip', 'contentFile' => 'XML-ZIP']])
            ->willReturn($response);

        return $client;
    }
}

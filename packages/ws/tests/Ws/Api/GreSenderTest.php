<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws\Api;

use Greenter\Api\GreSender;
use Greenter\Model\Response\SummaryResult;
use Greenter\Sunat\GRE\Api\CpeApiInterface;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Model\CpeError;
use Greenter\Sunat\GRE\Model\CpeErrorValidation;
use Greenter\Sunat\GRE\Model\CpeResponse;
use Greenter\Sunat\GRE\Model\StatusResponse;
use Greenter\Sunat\GRE\Model\StatusResponseError;
use Mockery;
use PHPUnit\Framework\TestCase;

class GreSenderTest extends TestCase
{
    public function testSendValid(): void
    {
        $api = Mockery::mock(CpeApiInterface::class);
        $api->shouldReceive('enviarCpe')
            ->andReturn(new CpeResponse(['num_ticket' => 'a.b.c', 'fec_recepcion' => '2023-01-10T20:10:50']));
        $sender = new GreSender($api);

        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");
        /**@var $result SummaryResult */
        $result = $sender->send($nameXml, $xml);

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('a.b.c', $result->getTicket());
    }

    public function testSendInValid(): void
    {
        $api = Mockery::mock(CpeApiInterface::class);
        $api->shouldReceive('enviarCpe')
            ->andThrowExceptions([
               $this->createException(422, new CpeErrorValidation([
                   'cod' => '422',
                   'msg' => 'Unprocessable Entity',
                   'errors' => [new CpeError(['cod' => '501', 'msg' => 'El valor de codCpe no permitido o no valido'])]
               ])),
                $this->createException(500, new CpeError(['cod' => '500', 'msg' => 'Internal Server Error'])),
                $this->createException(400, new CpeError())
            ]);
        $sender = new GreSender($api);

        $nameXml = '20600055519-01-F001-00000001';
        $xml = file_get_contents(__DIR__."/../../Resources/$nameXml.xml");
        /**@var $result SummaryResult */
        $result = $sender->send($nameXml, $xml);

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('501', $result->getError()->getCode());

        /**@var $result SummaryResult */
        $result = $sender->send($nameXml, $xml);

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('500', $result->getError()->getCode());

        /**@var $result SummaryResult */
        $result = $sender->send($nameXml, $xml);

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('API', $result->getError()->getCode());
    }

    public function testStatusCompleted(): void
    {
        $api = Mockery::mock(CpeApiInterface::class);
        $api->shouldReceive('consultarEnvio')
            ->andReturn(
                new StatusResponse([
                    'cod_respuesta' => '0',
                    'arc_cdr' => base64_encode(file_get_contents(__DIR__."/../../Resources/cdrGRE.zip")),
                    'ind_cdr_generado' => '1',
                ])
            );
        $sender = new GreSender($api);
        $result = $sender->status('a.b.c');
        $cdr = $result->getCdrResponse();
        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getCdrZip());
        $this->assertStringStartsWith('https://e-factura.sunat.gob.pe/', $cdr->getReference());
        $this->assertEquals(1, count($cdr->getNotes()));
        $this->assertEquals('T001-1', $cdr->getId());
        $this->assertEquals('0', $cdr->getCode());
    }

    public function testStatusPending(): void
    {
        $api = Mockery::mock(CpeApiInterface::class);
        $api->shouldReceive('consultarEnvio')
            ->andThrowExceptions([
                $this->createException(500, new CpeError(['cod' => '500', 'msg' => 'Internal Server Error'])),
            ]);
        $sender = new GreSender($api);
        $result = $sender->status('a.b.c');

        $this->assertFalse($result->isSuccess());
        $this->assertEmpty($result->getCode());
        $this->assertNotNull($result->getError());
    }

    public function testStatusError(): void
    {
        $api = Mockery::mock(CpeApiInterface::class);
        $api->shouldReceive('consultarEnvio')
            ->andReturn(
                new StatusResponse([
                    'cod_respuesta' => '98',
                    'ind_cdr_generado' => '0',
                ]),
                new StatusResponse([
                    'cod_respuesta' => '99',
                    'error' => new StatusResponseError([
                        'num_error' => '1345',
                        'des_error' => 'El RUC no valido'
                    ]),
                    'ind_cdr_generado' => '0',
                ])
            );
        $sender = new GreSender($api);
        $result = $sender->status('a.b.c');

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('98', $result->getCode());

        $result = $sender->status('a.b.c');

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('99', $result->getCode());
        $this->assertEquals('1345', $result->getError()->getCode());
    }

    private function createException(int $code, object $data): ApiException
    {
        $ex = new ApiException('TEST ERROR', $code);
        $ex->setResponseObject($data);

        return $ex;
    }
}

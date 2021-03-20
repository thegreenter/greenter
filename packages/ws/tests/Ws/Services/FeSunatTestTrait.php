<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Services\SenderInterface;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsClientInterface;
use Mockery;
use SoapFault;
use stdClass;

/**
 * trait FeSunatTestTrait.
 */
trait FeSunatTestTrait
{
    /**
     * @return SenderInterface
     */
    private function getBillSender()
    {
        $sender = new BillSender();
        $sender->setCodeProvider($this->getErrorCodeProviderMock());
        $sender->setClient($this->getClient());

        return $sender;
    }

    /**
     * @param string $code
     *
     * @return SenderInterface
     */
    private function getBillSenderThrow($code)
    {
        $sender = new BillSender();
        $sender->setCodeProvider($this->getErrorCodeProviderMock());
        $sender->setClient($this->getClientThrowMock($code));

        return $sender;
    }

    private function getBillSenderThrowWithDetail(string $code, object $detail)
    {
        $sender = new BillSender();

        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->andThrowExceptions([new SoapFault($code, 'ERROR TEST', null, $detail)]);

        $sender->setClient($client);

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    private function getBillSenderNoCdrMock()
    {
        $response = new stdClass();
        $response->applicationResponse = null;

        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')->andReturn($response);

        $sender = new BillSender();
        $sender->setClient($client);

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    private function getSummarySender()
    {
        $sender = new SummarySender();
        $sender->setClient($this->getClient());

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    private function getBillSenderMock()
    {
        $sender = Mockery::mock(SenderInterface::class);
        $sender->shouldReceive('send')->andReturn(
            (new BillResult())
            ->setCdrResponse((new CdrResponse())
                ->setCode('0')
                ->setDescription('La Factura numero F001-00000001, ha sido aceptada')
                ->setId('F001-00000001'))
            ->setSuccess(true)
        );

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    private function getSummarySenderMock()
    {
        $obj = new stdClass();
        $obj->ticket = '1500523236696';

        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')->andReturn($obj);

        $sender = new SummarySender();
        $sender->setClient($client);

        return $sender;
    }

    /**
     * @param string $code
     *
     * @return SenderInterface
     */
    private function getSummarySenderThrow($code)
    {
        $sender = new SummarySender();
        $sender->setClient($this->getClientThrowMock($code));

        return $sender;
    }

    /**
     * @param string $code FaultCode
     *
     * @return ExtService
     */
    private function getExtServiceForFault($code)
    {
        $client = $this->getClientThrowMock($code);
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }

    /**
     * @return SoapClient
     */
    private function getClient()
    {
        $client = new SoapClient();
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService(SunatEndpoints::FE_BETA);

        return $client;
    }

    /**
     * @param $code
     *
     * @return WsClientInterface
     */
    private function getClientThrowMock($code)
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->andThrowExceptions([new SoapFault($code, 'ERROR TEST')]);

        return $client;
    }

    private function getErrorCodeProviderMock()
    {
        $provider = Mockery::mock(ErrorCodeProviderInterface::class);
        $provider->shouldReceive('getValue')
            ->andReturnUsing(function ($err) {
                $items = [
              '0156' => 'El archivo ZIP esta corrupto',
            ];

                return $items[$err];
            });

        return $provider;
    }

    /**
     * @return ExtService
     */
    private function getExtServiceMock()
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->with('getStatus', Mockery::type('array'))
            ->andReturnUsing(function ($_, $args) {
                $ticket = $args['parameters']['ticket'];

                $obj = new stdClass();
                if ($ticket === '1500523236600') return $obj;

                $obj->status = new stdClass();
                switch ($ticket) {
                    case '223123123213':
                        $obj->status->statusCode = '98';
                        break;
                    case '223123123214':
                        $obj->status->statusCode = '0'; // Código procesado: 0, pero sin zip.
                        $obj->status->content = '';
                        break;
                    case '667123123214':
                        $obj->status->statusCode = '1002';
                        $obj->status->statusMessage = 'ERROR Z';
                        break;
                    default:
                        $obj->status->statusCode = '0';
                        $obj->status->content = file_get_contents(__DIR__.'/../../Resources/cdrBaja.zip');
                }

                return $obj;
            });

        /** @var $stub WsClientInterface */
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }
}

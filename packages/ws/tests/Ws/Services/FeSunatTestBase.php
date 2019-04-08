<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16
 */

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

/**
 * Class FeSunatTestBase
 * @package Tests\Greenter\Ws\Services
 */
abstract class FeSunatTestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ExtService
     */
    public function getExtSunat()
    {
        $client = new SoapClient(SunatEndpoints::FE_CONSULTA_CDR . '?wsdl');
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }

    /**
     * @return SenderInterface
     */
    protected function getBillSender()
    {
        $sender = new BillSender();
        $sender->setCodeProvider($this->getErrorCodeProviderMock());
        $sender->setClient($this->getClient());

        return $sender;
    }

    /**
     * @param string $code
     * @return SenderInterface
     */
    protected function getBillSenderThrow($code)
    {
        $sender = new BillSender();
        $sender->setCodeProvider($this->getErrorCodeProviderMock());
        $sender->setClient($this->getClientThrowMock($code));

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    protected function getBillSenderMock()
    {
        $stub = $this->getMockBuilder(SenderInterface::class)
            ->getMock();
        $stub->method('send')->will($this->returnValue((new BillResult())
            ->setCdrResponse((new CdrResponse())
                ->setCode('0')
                ->setDescription('La Factura numero F001-00000001, ha sido aceptada')
                ->setId('F001-00000001'))
            ->setSuccess(true)
        ));

        /**@var $stub SenderInterface*/
        return $stub;
    }

    /**
     * @return SenderInterface
     */
    protected function getSummarySender()
    {
        $sender = new SummarySender();
        $sender->setClient($this->getClient());

        return $sender;
    }

    /**
     * @return SenderInterface
     */
    protected function getSummarySenderMock()
    {
        $stub = $this->getMockBuilder(WsClientInterface::class)
            ->getMock();
        $stub->method('call')->will($this->returnCallback(function (){
            $obj = new \stdClass();
            $obj->ticket = '1500523236696';
            return $obj;
        }));

        /**@var $stub WsClientInterface*/
        $sender = new SummarySender();
        $sender->setClient($stub);
        return $sender;
    }

    /**
     * @param string $code
     * @return SenderInterface
     */
    protected function getSummarySenderThrow($code)
    {
        $sender = new SummarySender();
        $sender->setClient($this->getClientThrowMock($code));

        return $sender;
    }

    /**
     * @param string $code FaultCode
     * @return ExtService
     */
    protected function getExtServiceForFault($code)
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
     * @return WsClientInterface
     */
    private function getClientThrowMock($code)
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->andThrowExceptions([new \SoapFault($code, 'ERROR TEST')]);

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
    protected function getExtServiceMock()
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->with('getStatus', Mockery::type('array'))
            ->andReturnUsing(function ($_, $args) {
                $ticket = $args['parameters']['ticket'];

                $obj = new \stdClass();
                $obj->status = new \stdClass();

                if ($ticket === '223123123213') {
                    $obj->status->statusCode = '98';
                } else {
                    $obj->status->statusCode = '0';
                    $obj->status->content = file_get_contents(__DIR__.'/../../Resources/cdrBaja.zip');
                }

                return $obj;
            });

        /**@var $stub WsClientInterface */
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }
}
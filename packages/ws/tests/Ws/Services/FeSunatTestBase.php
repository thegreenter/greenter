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
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsClientInterface;

/**
 * Class FeSunatTestBase
 * @package Tests\Greenter\Ws\Services
 */
abstract class FeSunatTestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return ExtService
     */
    protected function getExtSender()
    {
        $stub = $this->getMockBuilder(WsClientInterface::class)
                    ->getMock();

        $stub->method('call')
                ->will($this->returnCallback(function ($func, $params) {
                    $zipContent = file_get_contents(__DIR__.'/../../Resources/cdrBaja.zip');
                    $obj = new \stdClass();
                    if ($func == 'getStatus') {
                        $obj->status = new \stdClass();
                        $obj->status->statusCode = '0';
                        $obj->status->content = $zipContent;
                    } elseif ($func == 'getStatusCdr') {
                        $obj->statusCdr = new \stdClass();
                        $obj->statusCdr->statusCode = '0';
                        $obj->statusCdr->statusMessage = 'ACEPTADA';
                        $obj->statusCdr->content = $zipContent;
                    }

                    return $obj;
                }));

        /**@var $stub WsClientInterface */
        $sunat = new ExtService();
        $sunat->setClient($stub);

        return $sunat;
    }

    /**
     * @return ExtService
     */
    public function getExtSunat()
    {
        $client = new SoapClient(SunatEndpoints::FE_CONSULTA_CDR . '?wsdl');
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService(SunatEndpoints::FE_CONSULTA_CDR);
        $sunat = new ExtService();
        $sunat->setClient($client);

        return $sunat;
    }

    /**
     * @return SenderInterface
     */
    protected function getBillSender()
    {
        $sender = new BillSender();
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
        $sender->setClient($this->getClientMock($code));

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
        $sender->setClient($this->getClientMock($code));

        return $sender;
    }

    /**
     * @param string $code FaultCode
     * @return ExtService
     */
    protected function getExtServiceForFault($code)
    {
        $client = $this->getClientMock($code);
        $sunat = new ExtService();
        $sunat->setClient($client);

        return $sunat;
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
    private function getClientMock($code)
    {
        $stub = $this->getMockBuilder(WsClientInterface::class)
            ->getMock();
        $stub->method('call')->will($this->throwException(new \SoapFault($code, 'ERROR TEST')));

        /**@var $stub WsClientInterface */
        return $stub;
    }
}
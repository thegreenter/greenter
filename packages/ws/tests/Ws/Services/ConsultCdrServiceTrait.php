<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/09/2018
 * Time: 15:19
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsClientInterface;

/**
 * Trait ConsultCdrServiceTrait
 *
 * @method \PHPUnit_Framework_MockObject_MockBuilder getMockBuilder($className)
 */
trait ConsultCdrServiceTrait
{
    /**
     * @return ConsultCdrService
     */
    private function getConsultService()
    {
        $client = new SoapClient(__DIR__.'/../../../src/Resources/wsdl/billConsultService.wsdl');
        $client->setService(SunatEndpoints::FE_CONSULTA_CDR);
        $client->setCredentials('20000000001MODATOS', 'modatos');

        $sunat = new ConsultCdrService();
        $sunat->setClient($client);

        return $sunat;
    }

    /**
     * @return ConsultCdrService
     */
    private function getConsultSender()
    {
        $stub = $this->getMockBuilder(WsClientInterface::class)
            ->getMock();

        $stub->method('call')
            ->will($this->returnCallback(function ($func, $params) {
                $obj = new \stdClass();
                if ($func == 'getStatus') {
                    $obj->status = new \stdClass();
                    $obj->status->statusCode = '0';
                    $obj->status->statusMessage = 'ACEPTADA';
//                    $obj->status->content = null;
                } elseif ($func == 'getStatusCdr') {
                    $zipContent = file_get_contents(__DIR__.'/../../Resources/cdrBaja.zip');
                    $obj->statusCdr = new \stdClass();
                    $obj->statusCdr->statusCode = '0';
                    $obj->statusCdr->statusMessage = 'ACEPTADA';
                    $obj->statusCdr->content = $zipContent;
                }

                return $obj;
            }));

        /**@var $stub WsClientInterface */
        $sunat = new ConsultCdrService();
        $sunat->setClient($stub);

        return $sunat;
    }
}
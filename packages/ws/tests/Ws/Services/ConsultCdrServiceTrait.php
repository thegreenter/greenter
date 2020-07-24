<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/09/2018
 * Time: 15:19.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Ws\Services\WsClientInterface;
use Greenter\Ws\Services\WsdlProvider;
use Mockery;

/**
 * Trait ConsultCdrServiceTrait.
 */
trait ConsultCdrServiceTrait
{
    /**
     * @return ConsultCdrService
     */
    private function getConsultService()
    {
        $client = new SoapClient(WsdlProvider::getConsultPath());
        $client->setService(SunatEndpoints::FE_CONSULTA_CDR);
        $client->setCredentials('20000000001MODATOS', 'modatos');

        $sunat = new ConsultCdrService();
        $sunat->setClient($client);

        return $sunat;
    }

    private function getConsultServiceMock()
    {
        $client = Mockery::mock(WsClientInterface::class);
        $client->shouldReceive('call')
            ->with('getStatus', Mockery::type('array'))
            ->andReturnUsing(function () {
                $obj = new \stdClass();
                $obj->status = new \stdClass();
                $obj->status->statusCode = '0';
                $obj->status->statusMessage = 'ACEPTADA';

                return $obj;
            });

        $client->shouldReceive('call')
            ->with('getStatusCdr', Mockery::type('array'))
            ->andReturnUsing(function ($_, array $params) {
                $ruc = $params['parameters']['rucComprobante'];
                $obj = new \stdClass();
                $obj->statusCdr = new \stdClass();

                if ('20000000001' === $ruc) {
                    $obj->statusCdr->statusCode = '0';
                    $obj->statusCdr->statusMessage = 'ACEPTADA';
                    $obj->statusCdr->content = file_get_contents(__DIR__.'/../../Resources/cdrBaja.zip');
                } else {
                    $obj->statusCdr->statusCode = '004';
                    $obj->statusCdr->statusMessage = 'Constancia Existe';
                    $obj->statusCdr->content = file_get_contents(__DIR__.'/../../Resources/cdr-rechazo.zip');
                }

                return $obj;
            });

        $service = new ConsultCdrService();
        $service->setClient($client);

        return $service;
    }
}

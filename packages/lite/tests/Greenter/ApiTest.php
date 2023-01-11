<?php

declare(strict_types=1);

namespace Tests\Greenter;

use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Response\SummaryResult;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiTest
 * @group integration
 */
class ApiTest extends TestCase
{
    public function testSend(): void
    {
        $api = $this->getApi();
        $despatch = $this->createDespatch();

        /**@var $result SummaryResult */
        $result = $api->send($despatch);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());

        $res = $api->getStatus($result->getTicket());
        $this->assertTrue($res->isSuccess());
        $this->assertEquals('0', $res->getCode());
        $this->assertNotEmpty($res->getCdrZip());
        $this->assertStringContainsString('ACEPTADA', $res->getCdrResponse()->getDescription());
        $this->assertStringStartsWith("http", $res->getCdrResponse()->getReference());
    }

    private function getApi(): Api
    {
        $api = new Api([
            'auth' => 'https://gre-test.nubefact.com/v1',
            'cpe' => 'https://gre-test.nubefact.com/v1',
        ]);

        return $api->setBuilderOptions([
                'strict_variables' => true,
                'optimizations' => 0,
                'debug' => true,
                'cache' => false,
            ])
            ->setApiCredentials('test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==')
            ->setClaveSOL('20161515648', 'MODDATOS', 'MODDATOS')
            ->setCertificate(file_get_contents(__DIR__.'/../Resources/SFSCert.pem'));
    }

    private function createDespatch(): Despatch
    {
        $envio = (new Shipment())
            ->setCodTraslado('01')
            ->setIndicadores(['SUNAT_Envio_IndicadorTrasladoVehiculoM1L'])
            ->setModTraslado('02')
            ->setFecTraslado(new DateTime())
            ->setPesoTotal(12.5)
            ->setUndPesoTotal('KGM')
            ->setLlegada(new Direction('150101', 'AV LIMA'))
            ->setPartida(new Direction('150203', 'AV ITALIA'));

        $despatch = new Despatch();
        $despatch->setVersion('2022')
            ->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('1')
            ->setFechaEmision(new DateTime())
            ->setCompany((new Company())
                ->setRuc('20161515648')
                ->setRazonSocial('GREENTER SAC'))
            ->setDestinatario((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000002')
                ->setRznSocial('EMPRESA DEST 1'))
            ->setEnvio($envio);

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
            ->setCodigo('PROD1');

        return $despatch->setDetails([$detail]);
    }
}
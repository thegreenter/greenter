<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:00
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\AdditionalDoc;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Driver;
use Greenter\Model\Despatch\Puerto;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\Vehicle;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\DetailAttribute;

class Despatch2022Store implements DocumentGeneratorInterface
{
    /**
     * @var SharedStore
     */
    private $shared;

    public function __construct(SharedStore $shared)
    {
        $this->shared = $shared;
    }

    public function create(): ?DocumentInterface
    {
        $rel = new AdditionalDoc();
        $rel->setTipoDesc('Factura')
            ->setTipo('01')
            ->setNro('F001-1')
            ->setEmisor('20111111110');

        $transp = new Transportist();
        $transp->setTipoDoc('6')
            ->setNumDoc('20000000002')
            ->setRznSocial('TRANSPORTES S.A.C')
            ->setNroMtc('100101');

        $conductor = (new Driver())
        ->setTipo('Principal')
        ->setTipoDoc('01')
        ->setNroDoc('00000011')
        ->setNombres('Juan')
        ->setApellidos('Perez')
        ->setLicencia('AAAAA');

        $vehiculo = (new Vehicle())
            ->setPlaca('AAA-111')
            ->setNroCirculacion('1111')
            ->setNroAutorizacion('2222')
            ->setCodEmisor('000001')
            ->setSecundarios([(new Vehicle())
                ->setPlaca('BBB-111')
                ->setNroCirculacion('33333')
                ->setNroAutorizacion('4444')
                ->setCodEmisor('000001')]);

        $envio = new Shipment();
        $envio->setModTraslado('01')
            ->setCodTraslado('01')
            ->setDesTraslado('VENTA ÚX')
            ->setFecTraslado(new \DateTime())
            ->setChoferes([$conductor])
            ->setVehiculo($vehiculo)
            ->setPuerto((new Puerto())
                ->setCodigo('01')
                ->setNombre('Puerto 1'))
            ->setAeropuerto((new Puerto())
                ->setCodigo('02')
                ->setNombre('Aeropuerto 1'))
            ->setIndicadores(['SUNAT_Envio_IndicadorTrasladoVehiculoM1L'])
            ->setPesoTotal(12.5)
            ->setUndPesoTotal('KGM')
            ->setPesoItems(10.23)
            ->setSustentoPeso('Ninguna')
            ->setNumBultos(2)
            ->setContenedores(['0000001', '0000002'])
            ->setLlegada((new Direction('150101', 'AV LIMA'))
                ->setCodLocal('00001')
                ->setRuc('20000000001'))
            ->setPartida((new Direction('150203', 'AV ITALIA'))
                ->setCodLocal('00002')
                ->setRuc('20000000002'))
            ->setTransportista($transp);

        // only one port is allowed
        if ($envio->getAeropuerto()) {
            $envio->setPuerto(null);
        }

        $despatch = new Despatch();
        $despatch->setVersion('2022')
            ->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->shared->getCompany())
            ->setDestinatario($this->shared->getClient())
            ->setTercero((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000003')
                ->setRznSocial('GREENTER SA'))
            ->setComprador((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000004')
                ->setRznSocial('EMPRESA SAC'))
            ->setObservacion('NOTA GUIA')
            ->setAddDocs([$rel])
            ->setEnvio($envio);

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
            ->setCodigo('PROD1')
            ->setCodProdSunat('P001');

        $detail2 = new DespatchDetail();
        $detail2->setCantidad(0.123456789111) // xml formateará a 10 decimales
            ->setUnidad('KGM')
            ->setDescripcion('PROD 2')
            ->setCodigo('PROD2')
            ->setCodProdSunat('P002')
            ->setAtributos([
                (new DetailAttribute())
                ->setCode('01')
                ->setName('CONCEPTO')
                ->setValue('TEST')
            ]);

        $despatch->setDetails([$detail, $detail2]);

        return $despatch;
    }
}
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
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Document;

class DespatchStore implements DocumentGeneratorInterface
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
        $baja = new Document();
        $baja->setTipoDoc('09')
            ->setNroDoc('T001-00001');

        $rel = new Document();
        $rel->setTipoDoc('02') // Tipo: Numero de Orden de Entrega
        ->setNroDoc('213123');

        $transp = new Transportist();
        $transp->setTipoDoc('6')
            ->setNumDoc('20000000002')
            ->setRznSocial('TRANSPORTES S.A.C')
            ->setPlaca('ABI-453')
            ->setChoferTipoDoc('1')
            ->setChoferDoc('40003344');

        $envio = new Shipment();
        $envio->setModTraslado('01')
            ->setCodTraslado('01')
            ->setDesTraslado('VENTA ÚX')
            ->setFecTraslado(new \DateTime())
            ->setCodPuerto('123')
            ->setIndTransbordo(false)
            ->setPesoTotal(12.5)
            ->setUndPesoTotal('KGM')
            ->setNumBultos(2)
            ->setNumContenedor('XD-2232')
            ->setLlegada(new Direction('150101', 'AV LIMA'))
            ->setPartida(new Direction('150203', 'AV ITALIA'))
            ->setTransportista($transp);

        $despatch = new Despatch();
        $despatch->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->shared->getCompany())
            ->setDestinatario($this->shared->getClient())
            ->setTercero((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000003')
                ->setRznSocial('GREENTER SA'))
            ->setObservacion('NOTA GUIA')
            ->setDocBaja($baja)
            ->setRelDoc($rel)
            ->setEnvio($envio);

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
            ->setCodigo('PROD1')
            ->setCodProdSunat('P001');

        $despatch->setDetails([$detail]);

        return $despatch;
    }
}
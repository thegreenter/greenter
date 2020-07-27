<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:18 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Sale\Document;
use PHPUnit\Framework\TestCase;

class CeDespatchValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidateDespatch()
    {
        $despatch = $this->getDespatch();
        $validator = $this->getValidator();
        $errors = $validator->validate($despatch);

        $this->assertEquals(0, $errors->count());
    }

    /**
     * @return Despatch
     */
    private function getDespatch()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA (<!-- --> />) 1');

        list($baja, $rels, $envio) = $this->getExtras();
        $despatch = new Despatch();
        $despatch->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setDestinatario($client)
            ->setTercero($client)
            ->setObservacion('NOTA GUIA')
            ->setDocBaja($baja)
            ->setRelDoc($rels)
            ->setEnvio($envio)
            ->setCompany($this->getCompany());

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
            ->setCodProdSunat('P001')
            ->setCodigo('PROD1');

        $despatch->setDetails([$detail]);

        return $despatch;
    }

    /**
     * @return array
     */
    private function getExtras()
    {
        $baja = new Document();
        $baja->setTipoDoc('09')
            ->setNroDoc('T001-00001');

        $rel = new Document();
        $rel->setTipoDoc('09')
            ->setNroDoc('T001-00001');

        $dir = new Direction('', '');
        $dir->setDireccion('AV ITALIA');
        $dir->setUbigueo('150203');

        $envio = new Shipment();
        $envio->setModTraslado('01')
            ->setCodTraslado('01')
            ->setDesTraslado('VENTA')
            ->setFecTraslado(new \DateTime())
            ->setCodPuerto('123')
            ->setIndTransbordo(true)
            ->setPesoTotal(12.5)
            ->setUndPesoTotal('KGM')
            ->setNumBultos(2)
            ->setNumContenedor('XD-2232')
            ->setLlegada(new Direction('150101', 'AV LIMA'))
            ->setPartida($dir)
            ->setTransportista($this->getTransportist());

        return [$baja, $rel, $envio];
    }

    private function getTransportist()
    {
        $transp = new Transportist();
        $transp->setTipoDoc('6')
            ->setNumDoc('20000000002')
            ->setRznSocial('TRANSPORTES S.A.C')
            ->setPlaca('ABI-453')
            ->setChoferTipoDoc('1')
            ->setChoferDoc('40003344');

        return $transp;
    }
}
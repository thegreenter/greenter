<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:18 PM
 */

namespace Tests\Greenter\Xml\Builder;
use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Sale\Document;

/**
 * Class CeDespatchBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeDespatchBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;

    public function testValidateDespatch()
    {
        $despatch = $this->getDespatch();
        $validator = $this->getValidator();
        $errors = $validator->validate($despatch);

        $this->assertEquals(0,$errors->count());
    }

    public function testCreateXmlDespatch()
    {
        $despatch = $this->getDespatch();

        $generator = $this->getGenerator();
        $xml = $generator->buildDespatch($despatch);

        $this->assertNotEmpty($xml);
        // file_put_contents('guia.xml', $xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testCreateXmlDespatchException()
    {
        $despatch = $this->getDespatch();
        $despatch->setSerie('T3333')
            ->setCorrelativo('000000000');

        $generator = $this->getGenerator();
        $generator->buildDespatch($despatch);
    }

    public function testDespatchFilename()
    {
        $ruc = $this->getCompany()->getRuc();
        $despatch = $this->getDespatch();
        $filename = $despatch->getFileName($ruc);

        $this->assertEquals($this->getFilename($despatch, $ruc), $filename);
    }

    private function getFileName(Despatch $despatch, $ruc)
    {
        $parts = [
            $ruc,
            '09',
            $despatch->getSerie(),
            $despatch->getCorrelativo(),
        ];

        return join('-', $parts);
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
            ->setRelDocs($rels)
            ->setEnvio($envio);

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
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

        $rel2 = new Document();
        $rel2->setTipoDoc('09')
            ->setNroDoc('T001-00002');

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
            ->setPartida(new Direction('150203', 'AV ITALIA'))
            ->setTransportista($this->getTransportist());

        return [$baja, [$rel, $rel2], $envio];
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
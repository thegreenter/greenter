<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:15
 */

namespace Tests\Greenter\Factory;

use Greenter\Factory\FeFactory;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Perception\PerceptionDetail;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Retention\RetentionDetail;
use Greenter\Model\Sale\Document;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ExtService;
use Greenter\Services\SenderInterface;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use Greenter\Xml\Builder\VoidedBuilder;
use Greenter\XMLSecLibs\Sunat\SignedXml;

/**
 * Class CeFactoryBase
 * @package Tests\Greenter\Factory
 */
class CeFactoryBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FeFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $builders;

    public function setUp()
    {
        $signer = new SignedXml();
        $signer->setCertificateFromFile(__DIR__.'/../../Resources/SFSCert.pem');

        $this->factory = new FeFactory();
        $this->factory->setSigner($signer);
        $this->builders = [
            Despatch::class => DespatchBuilder::class,
            Perception::class => PerceptionBuilder::class,
            Retention::class => RetentionBuilder::class,
            Reversion::class => VoidedBuilder::class,
        ];
    }

    /**
     * @param DocumentInterface $document
     * @return BaseResult|\Greenter\Model\Response\BillResult|\Greenter\Model\Response\SummaryResult
     */
    protected function getFactoryResult(DocumentInterface $document)
    {
        $url = SunatEndpoints::RETENCION_BETA;
        if ($document instanceof Despatch) {
            $url = SunatEndpoints::GUIA_BETA;
        }

        $sender = $this->getSender(get_class($document), $url);
        $builder = new $this->builders[get_class($document)]();

        $this->factory->setSender($sender);
        $this->factory->setBuilder($builder);

        return $this->factory->send($document);
    }

    /**
     * @param string $className
     * @param string $endpoint
     * @return SenderInterface
     */
    private function getSender($className, $endpoint)
    {
        $summValids = [Summary::class, Reversion::class];
        $client = new SoapClient();
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService($endpoint);
        $sender = in_array($className, $summValids) ? new SummarySender(): new BillSender();
        $sender->setClient($client);

        return $sender;
    }

    /**
     * @return ExtService
     */
    protected function getExtService()
    {
        $client = new SoapClient(SunatEndpoints::WSDL_ENDPOINT);
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService(SunatEndpoints::RETENCION_BETA);
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }

    /**
     * @param DocumentInterface $document
     * @return string
     */
    protected function getXmlSigned(DocumentInterface $document)
    {
        $builder = new $this->builders[get_class($document)]([
            'cache' => false,
            'strict_variables' => true,
        ]);
        $this->factory->setBuilder($builder);

        return $this->factory->getXmlSigned($document);
    }

    /**
     * @return Retention
     */
    protected function getRetention()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        list($pays, $cambio) = $this->getExtras();
        $retention = new Retention();
        $retention
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getCompany())
            ->setProveedor($client)
            ->setObservacion('NOTA /><!-- HI -->')
            ->setImpRetenido(10)
            ->setImpPagado(210)
            ->setRegimen('01')
            ->setTasa(3);

        $detail = new RetentionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaRetencion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpPagar(200)
            ->setImpRetenido(5)
            ->setPagos($pays)
            ->setTipoCambio($cambio);

        $retention->setDetails([$detail]);

        return $retention;
    }

    /**
     * @return Perception
     */
    protected function getPerception()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        list($pays, $cambio) = $this->getExtras();
        $perception = new Perception();
        $perception
            ->setSerie('P001')
            ->setCorrelativo('123')
            ->setFechaEmision($this->getDate())
            ->setObservacion('NOTA PRUEBA />')
            ->setCompany($this->getCompany())
            ->setProveedor($client)
            ->setImpPercibido(10)
            ->setImpCobrado(210)
            ->setRegimen('01')
            ->setTasa(2);

        $detail = new PerceptionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaPercepcion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpCobrar(210)
            ->setImpPercibido(10)
            ->setCobros($pays)
            ->setTipoCambio($cambio);

        $perception->setDetails([$detail]);

        return $perception;
    }

    /**
     * @return array
     */
    private function getExtras()
    {
        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        return [[$pay], $cambio];
    }

    /**
     * @return Reversion
     * @throws \Exception
     */
    protected function getReversion()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $fecGeneracion = clone $this->getDate();
        $fecGeneracion->sub(new \DateInterval('P2D'));
        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecComunicacion($this->getDate())
            ->setFecGeneracion($fecGeneracion)
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }

    /**
     * @return Despatch
     */
    protected function getDespatch()
    {
        list($baja, $rel, $envio) = $this->getExtrasDespatch();
        $despatch = new Despatch();
        $despatch->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDestinatario((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000002')
                ->setRznSocial('EMPRESA (<!-- --> />) 1'))
            ->setTercero((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000003')
                ->setRznSocial('EMPRESA SA'))
            ->setObservacion('NOTA GUIA')
            ->setDocBaja($baja)
            ->setRelDoc($rel)
            ->setEnvio($envio);

        $detail = new DespatchDetail();
        $detail->setCantidad(2)
            ->setUnidad('ZZ')
            ->setCodProdSunat('22222')
            ->setDescripcion('PROD 1')
            ->setCodigo('PROD1');

        $despatch->setDetails([$detail]);

        return $despatch;
    }

    /**
     * @return array
     */
    private function getExtrasDespatch()
    {
        $baja = new Document();
        $baja->setTipoDoc('09')
            ->setNroDoc('T001-00001');

        $rel = new Document();
        $rel->setTipoDoc('02') // Tipo: Numero de Orden de Entrega
            ->setNroDoc('213123');

        $envio = new Shipment();
        $envio->setModTraslado('01')
            ->setCodTraslado('01')
            ->setDesTraslado('VENTA')
            ->setFecTraslado(new \DateTime())
            ->setCodPuerto('123')
            ->setIndTransbordo(false)
            ->setPesoTotal(12.5)
            ->setUndPesoTotal('KGM')
            ->setNumBultos(2)
            ->setNumContenedor('XD-2232')
            ->setLlegada(new Direction('150101', 'AV LIMA'))
            ->setPartida(new Direction('150203', 'AV ITALIA'))
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

    /**
     * @return Company
     */
    private function getCompany()
    {
        $company = new Company();
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setDireccion('AV LS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }

    private function getDate()
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P1D'));

        return $date;
    }
}
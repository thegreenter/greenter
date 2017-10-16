<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:52
 */

namespace Tests\Greenter\Factory;

use Greenter\Factory\FeFactory;
use Greenter\Model\Client\Client;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryDetailV2;
use Greenter\Model\Summary\SummaryV2;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Validator\SymfonyValidator;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\ExtService;
use Greenter\Services\SenderInterface;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\SummaryV2Builder;
use Greenter\Xml\Builder\VoidedBuilder;

/**
 * Trait FeFactoryTrait
 * @package Tests\Greenter
 */
trait FeFactoryTraitTest
{
    /**
     * @var FeFactory
     */
    private $factory;

    /**
     * @var array
     */
    private $builders;

    /**
     * @var \DateTime
     */
    private $dateEmision;

    public function setUp()
    {
        $this->builders = [
            Invoice::class => InvoiceBuilder::class,
            Note::class => NoteBuilder::class,
            Summary::class => SummaryBuilder::class,
            Voided::class => VoidedBuilder::class,
            SummaryV2::class => SummaryV2Builder::class,
        ];

        $factory = new FeFactory();
        $factory->setCertificate(file_get_contents(__DIR__ . '/../../Resources/SFSCert.pem'));
        $this->factory = $factory;
        $date = new \DateTime();
        $date->sub(new \DateInterval('P1D'));
        $this->dateEmision = $date;
    }

    /**
     * @param string $className
     * @param string $endpoint
     * @return SenderInterface
     */
    private function getSender($className, $endpoint)
    {
        $client = new SoapClient(SunatEndpoints::WSDL_ENDPOINT);
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService($endpoint);
        $summValids = [Summary::class, SummaryV2::class, Voided::class];
        $sender = in_array($className, $summValids) ? new SummarySender(): new BillSender();
        $sender->setClient($client);

        return $sender;
    }

    /**
     * @param DocumentInterface $document
     * @return BaseResult|\Greenter\Model\Response\BillResult|\Greenter\Model\Response\SummaryResult
     */
    private function getFactoryResult(DocumentInterface $document)
    {
        $sender = $this->getSender(get_class($document), SunatEndpoints::FE_BETA);
        $builder = new $this->builders[get_class($document)]();
        $factory = $this->factory
            ->setBuilder($builder)
            ->setSender($sender)
            ->setValidator(new SymfonyValidator());

        return $factory->send($document);
    }

    /**
     * @return ExtService
     */
    private function getExtService()
    {
        $client = new SoapClient(SunatEndpoints::WSDL_ENDPOINT);
        $client->setCredentials('20000000001MODDATOS', 'moddatos');
        $client->setService(SunatEndpoints::FE_BETA);
        $service = new ExtService();
        $service->setClient($client);

        return $service;
    }

    private function getInvoice()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        $invoice = new Invoice();
        $invoice->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision($this->dateEmision)
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(2236.43)
            ->setCompany($this->getCompany());

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $invoice->setDetails([$detail1, $detail2])
            ->setLegends([$legend]);

        return $invoice;
    }

    private function getCreditNote()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        $note = new Note();
        $note
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-111')
            ->setCodMotivo('07')
            ->setDesMotivo('ANULACION DE LA OPERACION')
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setFechaEmision($this->dateEmision)
            ->setCorrelativo('123')
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany());

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $note->setDetails([$detail1, $detail2])
            ->setLegends([$legend]);

        return $note;
    }

    private function getDebitNote()
    {
        $debit = $this->getCreditNote();
        $debit->setCodMotivo('01')
            ->setDesMotivo('XXXX ')
            ->setTipoDoc('08')
            ->setFechaEmision($this->dateEmision);

        return $debit;
    }

    private function getSummary()
    {
        $detiail1 = new SummaryDetail();
        $detiail1->setTipoDoc('03')
            ->setSerie('B001')
            ->setDocInicio('1')
            ->setDocFin('4')
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetail();
        $detiail2->setTipoDoc('07')
            ->setSerie('BB01')
            ->setDocInicio('4')
            ->setDocFin('8')
            ->setTotal(200)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $sum = new Summary();
        $sum->setFecGeneracion($this->dateEmision)
            ->setFecResumen($this->dateEmision)
            ->setCorrelativo('001')
            ->setCompany($this->getCompany())
            ->setDetails([$detiail1, $detiail2]);

        return $sum;
    }

    private function getSummaryV2()
    {
        $detiail1 = new SummaryDetailV2();
        $detiail1->setTipoDoc('07')
            ->setSerieNro('B001-12')
            ->setClienteTipo('1')
            ->setClienteNro('44556677')
            ->setEstado('1')
            ->setDocReferencia((new Document())
                ->setTipoDoc('03')
                ->setNroDoc('B001-1'))
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(12)
            ->setMtoOperExoneradas(15)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetailV2();
        $detiail2->setTipoDoc('07')
            ->setSerieNro('B001-22')
            ->setClienteTipo('1')
            ->setClienteNro('55667733')
            ->setEstado('1')
            ->setTotal(200)
            ->setMtoOperGravadas(3)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(2)
            ->setMtoDescuentos(1)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $sum = new SummaryV2();
        $sum->setFecGeneracion($this->dateEmision)
            ->setFecResumen($this->dateEmision)
            ->setCorrelativo('001')
            ->setCompany($this->getCompany())
            ->setDetails([$detiail1, $detiail2]);

        return $sum;
    }

    private function getVoided()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('03')
            ->setSerie('B001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $voided = new Voided();
        $voided->setCorrelativo('001')
            ->setFecComunicacion($this->dateEmision)
            ->setFecGeneracion($this->dateEmision)
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $voided;
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
            ->setUrbanizacion('NONE')
            ->setDireccion('AV LS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }
}
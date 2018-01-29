<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 28/01/2018
 * Time: 18:58.
 */

namespace Greenter\Data;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Perception\PerceptionDetail;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Retention\RetentionDetail;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\EmbededDespatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryPerception;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;

/**
 * Trait StoreTrait.
 */
trait StoreTrait
{
    public function getInvoice()
    {
        $perc = new SalePerception();
        $perc->setCodReg('01')
            ->setMto(2)
            ->setMtoBase(3)
            ->setMtoTotal(4);

        $invoice = new Invoice();
        $invoice->setAnticipos([
            (new Prepayment())
                ->setNroDocRel('0001-211')
                ->setTipoDocRel('01')
                ->setTotal(100),
            (new Prepayment())
                ->setNroDocRel('0001-213')
                ->setTipoDocRel('01')
                ->setTotal(120),
        ]);
        $invoice
            ->setFecVencimiento(new \DateTime())
            ->setCompra('0000123232')
            ->setTotalAnticipos(120.24)
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setPerception($perc)
            ->setCompany($this->getCompany())
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($this->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setMtoImpVenta(236)
            ->setGuias([(new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-213'),
                (new Document())
                    ->setTipoDoc('09')
                    ->setNroDoc('001-442'),
            ]);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setIgv(18)
            ->setIsc(3)
            ->setTipSisIsc('3')
            ->setMtoValorGratuito(12)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C21')
            ->setUnidad('ZZ')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 2')
            ->setDescuento(1)
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(10)
            ->setMtoValorGratuito(2)
            ->setMtoPrecioUnitario(0);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $legend2 = new Legend();
        $legend2->setCode('1002')
            ->setValue('TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE');

        $legend3 = new Legend();
        $legend3->setCode('2000')
            ->setValue('COMPROBANTE DE PERCEPCION');

        $items = array_merge([$detail1, $detail2], $this->getItems($detail1, 6));
        $invoice->setDetails($items)
            ->setLegends([$legend, $legend2, $legend3]);

        return $invoice;
    }

    public function getFullInvoice()
    {
        $invoice = new Invoice();
        $invoice
            ->setFecVencimiento(new \DateTime())
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setTipoOperacion('2')
            ->setPerception((new SalePerception())
                ->setCodReg('01')
                ->setMto(2)
                ->setMtoBase(3)
                ->setMtoTotal(4)
            )->setCompra('001-12112')
            ->setDetraccion((new Detraction())
                ->setMount(2228.3)
                ->setPercent(9)
                ->setValueRef(2000)
            )->setGuiaEmbebida((new EmbededDespatch())
                ->setLlegada(new Direction('070101', 'AV. REPUBLICA DE ARGENTINA N? 2976 URB.'))
                ->setPartida(new Direction('070101', 'AV OSCAR R BENAVIDES No 5915  PE'))
                ->setTransportista((new Client())
                    ->setTipoDoc('6')
                    ->setNumDoc('20100006376')
                    ->setRznSocial('TRANS SAC')
                )->setNroLicencia('1111111111')
                ->setTranspPlaca('B9Y-778')
                ->setTranspCodeAuth('112121')
                ->setTranspMarca('Scania')
                ->setModTraslado('01')
                ->setUndPesoBruto('KGM')
                ->setPesoBruto(2020.23)
            )->setAnticipos([(new Prepayment())
                ->setTotal(100)
                ->setTipoDocRel('02')
                ->setNroDocRel('F001-21'),
                (new Prepayment())->setTotal(200)
                    ->setTipoDocRel('02')
                    ->setNroDocRel('F001-23')
            ])->setTotalAnticipos(300)
            ->setRelDocs([(new Document())
                ->setTipoDoc('01')
                ->setNroDoc('F001-123')
            ])
            ->setGuias([(new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-1')
            ])
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($this->getClient())->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany())
            ->setDetails([(new SaleDetail())
                ->setCodProducto('C023')
                ->setUnidad('NIU')
                ->setCantidad(2)
                ->setDescripcion('PROD 1')
                ->setIgv(18)
                ->setIsc(3)
                ->setTipSisIsc('3')
                ->setMtoValorGratuito(12)
                ->setTipAfeIgv('10')
                ->setMtoValorVenta(100)
                ->setMtoValorUnitario(50)
                ->setMtoPrecioUnitario(56)
                , (new SaleDetail())
                    ->setCodProducto('C02')
                    ->setCodProdSunat('001')
                    ->setUnidad('NIU')
                    ->setCantidad(2)
                    ->setDescripcion('PROD 2')
                    ->setDescuento(1)
                    ->setTipSisIsc('3')
                    ->setIsc(1)
                    ->setIgv(18)
                    ->setTipAfeIgv('10')
                    ->setMtoValorVenta(100)
                    ->setMtoValorUnitario(10)
                    ->setMtoValorGratuito(2)
                    ->setMtoPrecioUnitario(0)
            ])->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue('SON N CON 00/100 SOLES')
            ]);

        return $invoice;
    }

    public function getNote()
    {
        $note = new Note();
        $note
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-111')
            ->setCodMotivo('07')
            ->setDesMotivo('DEVOLUCION POR ITEM')
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setFechaEmision(new \DateTime())
            ->setCorrelativo('123')
            ->setTipoMoneda('PEN')
            ->setClient($this->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany());

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 1')
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $items = $this->getItems($detail1, 6);
        $note->setDetails($items)
            ->setLegends([$legend]);

        return $note;
    }

    public function getVoided()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('07')
            ->setSerie('FC01')
            ->setCorrelativo('222')
            ->setDesMotivoBaja('ERROR DE RUC');

        $voided = new Voided();
        $voided->setCorrelativo('00111')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $voided;
    }

    public function getReversion()
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

        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }

    public function getSummary()
    {
        $detiail1 = new SummaryDetail();
        $detiail1->setTipoDoc('03')
            ->setSerieNro('B001-1')
            ->setEstado('3')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoOtrosCargos(21)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetail();
        $detiail2->setTipoDoc('07')
            ->setSerieNro('B001-4')
            ->setDocReferencia((new Document())
                ->setTipoDoc('03')
                ->setNroDoc('0001-122'))
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(200)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $detiail3 = new SummaryDetail();
        $detiail3->setTipoDoc('03')
            ->setSerieNro('B001-2')
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setPercepcion((new SummaryPerception())
                ->setCodReg('01')
                ->setTasa(2.00)
                ->setMtoBase(100.00)
                ->setMto(2.00)
                ->setMtoTotal(102.00))
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoOtrosCargos(21)
            ->setMtoIGV(3.6);

        $sum = new Summary();
        $sum->setFecGeneracion(new \DateTime('-1days'))
            ->setFecResumen(new \DateTime('-1days'))
            ->setCorrelativo('001')
            ->setCompany($this->getCompany())
            ->setDetails([$detiail1, $detiail2, $detiail3]);

        return $sum;
    }

    public function getRetention()
    {
        $retention = new Retention();
        $retention
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getCompany())
            ->setProveedor($this->getClient())
            ->setObservacion('NOTA EXTRA')
            ->setImpRetenido(10)
            ->setImpPagado(210)
            ->setRegimen('01')
            ->setTasa(3);

        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        $detail = new RetentionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaRetencion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpPagar(200)
            ->setImpRetenido(5)
            ->setPagos([$pay])
            ->setTipoCambio($cambio);

        $items = $this->getItems($detail, 3);
        $retention->setDetails($items);

        return $retention;
    }

    public function getPerception()
    {
        $perception = new Perception();
        $perception
            ->setSerie('P001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setObservacion('NOTA EXTRA')
            ->setCompany($this->getCompany())
            ->setProveedor($this->getClient())
            ->setImpPercibido(10)
            ->setImpCobrado(210)
            ->setRegimen('01')
            ->setTasa(2);

        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        $detail = new PerceptionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaPercepcion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpCobrar(200)
            ->setImpPercibido(5)
            ->setCobros([$pay])
            ->setTipoCambio($cambio);

        $items = $this->getItems($detail, 4);
        $perception->setDetails($items);

        return $perception;
    }

    public function getDespatch()
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
            ->setTransportista($transp);

        $despatch = new Despatch();
        $despatch->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDestinatario($this->getClient())
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

        $items = $this->getItems($detail, 4);
        $despatch->setDetails($items);

        return $despatch;
    }

    public function getCompany()
    {
        return (new Company())
            ->setRuc('20123456789')
            ->setNombreComercial('GREENTER')
            ->setRazonSocial('GREENTER S.A.C')
            ->setAddress((new Address())
                ->setDireccion('AV LOS GERANIOS 321 - LIMA - LIMA - PERU'));
    }

    public function getClient()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1')
            ->setAddress((new Address())
                ->setDireccion('JR. NIQUEL MZA. F LOTE. 3 URB.  INDUSTRIAL INFANTAS - LIMA - LIMA -PERU'));

        return $client;
    }

    private function getItems($detail, $count)
    {
        $items = [];
        for ($i = 0; $i < $count; ++$i) {
            $items[] = $detail;
        }

        return $items;
    }
}

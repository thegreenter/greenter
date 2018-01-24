<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

namespace Tests\Greenter\Report;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use Greenter\Report\HtmlReport;

trait HtmlReportTrait
{
    /**
     * @return HtmlReport
     */
    private function getReporter()
    {
        $report = new HtmlReport('', ['cache' => false, 'strict_variables' => true]);
        $report->getTwig()->addGlobal('max_items', 7);

        return $report;
    }

    private function getInvoice()
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
                ->setTotal(120)
        ]);
        $invoice
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
                ->setNroDoc('001-442')
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

    private function getNote()
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

    private function getCompany()
    {
        return (new Company())
            ->setRuc('20123456789')
            ->setNombreComercial('EMPRESA')
            ->setRazonSocial('EMPRESA S.A.C')
            ->setAddress((new Address())
                ->setDireccion('AV ITALIA 232 - LIMA - LIMA - PERU'));
    }

    private function getClient()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1')
            ->setAddress((new Address())
                ->setDireccion('AV ITALIA 231 MZ K LT 4'));

        return $client;
    }

    private function getItems(SaleDetail $detail, $count)
    {
        $items = [];
        for ($i = 0; $i < $count; $i++) {
            $items[] = $detail;
        }

        return $items;
    }
}
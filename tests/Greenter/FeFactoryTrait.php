<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:52
 */

namespace Tests\Greenter;

use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;

/**
 * Trait FeFactoryTrait
 * @package Tests\Greenter
 */
trait FeFactoryTrait
{
    private function getInvoice()
    {
        $invoice = new Invoice();
        $invoice->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setTipoMoneda('PEN')
            ->setTipoDocUsuario('6')
            ->setNumDocUsuario('20000000001')
            ->setRznSocialUsuario('EMPRESA 1')
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236);

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
        $note = new Note();
        $note
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-111')
            ->setCodMotivo('07')
            ->setDesMotivo('ANULACION DE LA OPERACION')
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setCorrelativo('123')
            ->setTipoMoneda('PEN')
            ->setTipoDocUsuario('6')
            ->setNumDocUsuario('20000000001')
            ->setRznSocialUsuario('EMPRESA 1')
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236);

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
            ->setDesMotivo(' XXXXXXX ')
            ->setTipoDoc('08');

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
        $sum->setFecGeneracion(new \DateTime())
            ->setFecResumen(new \DateTime())
            ->setCorrelativo('001')
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
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
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
            ->setDireccion('AV LS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }
}
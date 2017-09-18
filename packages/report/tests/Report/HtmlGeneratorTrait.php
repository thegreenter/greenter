<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 22:17
 */

namespace Tests\Greenter\Report;

use Greenter\Report\HtmlGenerator;
use Greenter\Report\Model\Client;
use Greenter\Report\Model\Invoice;
use Greenter\Report\Model\Legend;
use Greenter\Report\Model\SaleDetail;
use Greenter\Report\Model\SalePerception;

/**
 * Trait HtmlGeneratorTrait
 * @package Tests\Greenter\Report
 */
trait HtmlGeneratorTrait
{
    /**
     * @return HtmlGenerator
     */
    private function getGenerator()
    {
        $parameters = ['cache' => sys_get_temp_dir()];
        if (!getenv('CI')) {
           $parameters['wkhtml_bin'] = "B:\\Archivos de Programa\\wkhtmltopdf\\bin\\wkhtmltopdf.exe";
        }

        $gen = new HtmlGenerator();
        $gen->setParameters($parameters);

        return $gen;
    }

    private function getInvoice()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');
        $perc = new SalePerception();
        $perc->setCodReg('01')
            ->setMto(2)
            ->setMtoBase(3)
            ->setMtoTotal(4);

        $invoice = new Invoice();
        $invoice
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setPerception($perc)
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setMtoImpVenta(236);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setMtoIscItem(3)
            ->setTipSisIsc('3')
            ->setMtoValorGratuito(12)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoDsctoItem(1)
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(10)
            ->setMtoValorGratuito(2)
            ->setMtoPrecioUnitario(0);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $invoice->setDetails([$detail1, $detail2])
            ->setLegends([$legend]);

        return $invoice;
    }
}
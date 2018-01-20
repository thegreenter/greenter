<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 22:17
 */

namespace Tests\Greenter\Report;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use Greenter\Report\HtmlReport;

/**
 * Trait HtmlReportTest
 * @package Tests\Greenter\Report
 */
class HtmlReportTest extends \PHPUnit_Framework_TestCase
{

    public function testGenReport()
    {
        $inv = $this->getInvoice();
        $report = new HtmlReport();
        $report->setTemplate('invoice.html.twig');

        try {
            $html = $report->render($inv, $this->getParamters());
            $this->assertNotEmpty($html);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
        // file_put_contents('file.html', $html);
    }

    private function getParamters()
    {
        $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(__DIR__.'/../Resources/logo.png'));
        $qrcode = 'data:image/png;base64,' . base64_encode(file_get_contents(__DIR__.'/../Resources/qrcode.png'));

        return [
            'system' => [
                'logo' => $logo,
                'qrcode' => $qrcode,
                'nameDoc' => 'FACTURA ELECTRÓNICA',
                'montletras' => 'CIEN CON 00/100 NUEVOS SOLES',
                'clientDoc' => 'RUC',
            ],
            'user' => [
                'telefono' => '(056) 123375'
            ]
        ];
    }

    private function getInvoice()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1')
        ->setAddress((new Address())
        ->setDireccion('AV ITALIA 231 MZ K LT 4'));
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
            ->setCompany((new Company())
                ->setRuc('20123456789')
                ->setNombreComercial('EMPRESA')
                ->setRazonSocial('EMPRESA S.A.C')
                ->setAddress((new Address())
                    ->setDireccion('AV ITALIA 232 - LIMA - LIMA - PERU')))
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
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 2')
            ->setDescuento(1)
            ->setIgv(18)
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
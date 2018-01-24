<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\EmbededDespatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

/**
 * Class FeInvoiceBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeInvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlInvoice()
    {
        $invoice = $this->getInvoice();
        $xml = $this->build($invoice);

        $this->assertNotEmpty($xml);
        $this->assertInvoiceSchema($xml);

//        file_put_contents('x.xml', $xml);
    }

    public function testCompanyValidate()
    {
        $company = $this->getCompany();
        $adress = $company->getAddress();

        $this->assertNotNull($company->getAddress());
        $this->assertNotEmpty($company->getNombreComercial());
        $this->assertNotEmpty($company->getRazonSocial());
        $this->assertNotEmpty($company->getRuc());
        $this->assertNotEmpty($adress->getDepartamento());
        $this->assertNotEmpty($adress->getProvincia());
        $this->assertNotEmpty($adress->getDistrito());
        $this->assertNotEmpty($adress->getUrbanizacion());
    }

    public function testInvoiceFilename()
    {
        $invoice = $this->getInvoice();
        $filename = $invoice->getName();

        $this->assertEquals($this->getFilename($invoice), $filename);
    }

    private function getFileName(Invoice $invoice)
    {
        $parts = [
            $invoice->getCompany()->getRuc(),
            $invoice->getTipoDoc(),
            $invoice->getSerie(),
            $invoice->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    private function getInvoice()
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
            ->setClient((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000001')
                ->setRznSocial('EMPRESA 1')
            )->setMtoOperGravadas(200)
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
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:44
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\Company\Address;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

class InvoiceStore implements DocumentGeneratorInterface
{
    /**
     * @var SharedStore
     */
    private $shared;

    public function __construct(SharedStore $shared)
    {
        $this->shared = $shared;
    }

    public function create(): ?DocumentInterface
    {
        $perc = new SalePerception();
        $perc->setCodReg('01') // 51 on UBL2.1 - Catalog 53
        ->setMto(2)
            ->setPorcentaje(2.00)
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
            ->setFecVencimiento(new DateTime())
            ->setCompra('0000123232')
            ->setTotalAnticipos(120.24)
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setSumOtrosDescuentos(24)
            ->setPerception($perc)
            ->setCompany($this->shared->getCompany())
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime())
            ->setFormaPago(new FormaPagoContado())
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setSeller($this->shared->getSeller())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setTotalImpuestos(38)
            ->setMtoISC(2)
            ->setValorVenta(200)
            ->setSubTotal(236)
            ->setMtoImpVenta(236)
            ->setGuias([(new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-213'),
                (new Document())
                    ->setTipoDoc('09')
                    ->setNroDoc('001-442'),
            ])->setDireccionEntrega((new Address())
                ->setUbigueo('150101')
                ->setDistrito('LIMA')
                ->setProvincia('LIMA')
                ->setDepartamento('LIMA')
                ->setUrbanizacion('ASINC')
                ->setDireccion('ALGARROBOS 1650'));

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100.00)
            ->setPorcentajeIgv(18.0)
            ->setIgv(18)
            ->setMtoBaseIsc(10)
            ->setPorcentajeIsc(0.50)
            ->setIsc(3)
            ->setTipSisIsc('03')
            ->setTotalImpuestos(21)
            ->setMtoValorGratuito(12)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C21')
            ->setUnidad('ZZ')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO ÁÍ 2')
            ->setDescuento(1)
            ->setDescuentos([
                (new Charge())
                    ->setCodTipo('00')
                    ->setFactor(5.00)
                    ->setMontoBase(100)
                    ->setMonto(5)
            ])
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.0)
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18)
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

        $invoice->setDetails([$detail1, $detail2])
            ->setLegends([$legend, $legend2, $legend3]);

        return $invoice;
    }
}
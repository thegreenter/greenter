<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:11
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\DetailAttribute;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\EmbededDespatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\PaymentTerms;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

class InvoiceFullStore implements DocumentGeneratorInterface
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
        $invoice = new Invoice();
        $invoice
            ->setFecVencimiento(new DateTime())
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setSumOtrosDescuentos(24)
            ->setTipoOperacion('2')
            ->setPerception(
                (new SalePerception())
                ->setCodReg('01')
                ->setPorcentaje(2.00)
                ->setMto(2)
                ->setMtoBase(3)
                ->setMtoTotal(4)
            )->setCompra('001-12112')
            ->setDetraccion(
                (new Detraction())
                ->setMount(2228.3)
                ->setPercent(9)
                ->setValueRef(2000)
            )->setGuiaEmbebida(
                (new EmbededDespatch())
                ->setLlegada(new Direction('070101', 'AV. REPUBLICA DE ARGENTINA N? 2976 URB.'))
                ->setPartida(new Direction('070101', 'AV OSCAR R BENAVIDES No 5915  PE'))
                ->setTransportista(
                    (new Client())
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
            ->setCargos([
                (new Charge())
                ->setCodTipo('04') // catalog. 53
                ->setFactor(1)
                ->setMonto(100) // anticipo
                ->setMontoBase(100)
            ])
            ->setDescuentos([
                (new Charge())
                    ->setCodTipo('00') // Catalog. 53
                    ->setMontoBase(200)
                    ->setFactor(0.10)
                    ->setMonto(20)
            ])
            ->setFormaPago(
                (new PaymentTerms())
                    ->setTipo('Credito')
                    ->setMonto(123.122)
                    ->setMoneda('PEN')
            )
            ->setCuotas([
                (new Cuota())
                    ->setMonto(23.23)
                    ->setFechaPago(new DateTime('2021-02-07 00:00:00-05:00'))
                    ->setMoneda('PEN')
            ])
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setObservacion('FACTURA DE PRUEBA')
            ->setClient($this->shared->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoOperExportacion(0)
            ->setMtoBaseIsc(24)
            ->setMtoBaseOth(16)
            ->setMtoIGV(36)
            ->setMtoIGVGratuitas(0)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setTotalImpuestos(39)
            ->setValorVenta(200)
            ->setSubTotal(236)
            ->setRedondeo(0.02)
            ->setMtoImpVenta(236)
            ->setCompany($this->shared->getCompany())
            ->setDetails([
                (new SaleDetail())
                ->setCodProducto('C023')
                ->setUnidad('NIU')
                ->setCantidad(2)
                ->setDescripcion('PROD 1')
                ->setMtoBaseIgv(100)
                ->setPorcentajeIgv(18.0)
                ->setIgv(18)
                ->setMtoBaseIsc(60)
                ->setPorcentajeIsc(0.50)
                ->setIsc(3)
                ->setTipSisIsc('3')
                ->setTipAfeIgv('10')
                ->setTotalImpuestos(21)
                ->setMtoValorVenta(100)
                ->setMtoValorUnitario(50.44556677881233)
                ->setMtoPrecioUnitario(56.3215)
                ,
                (new SaleDetail())
                    ->setCodProducto('C02')
                    ->setCodProdSunat('001')
                    ->setCodProdGS1('123456789')
                    ->setUnidad('NIU')
                    ->setCantidad(2)
                    ->setDescripcion('PROD 2')
                    ->setDescuento(1)
                    ->setCargos([
                        (new Charge())
                            ->setCodTipo('01')
                            ->setFactor(5.00)
                            ->setMontoBase(100)
                            ->setMonto(5)
                    ])
                    ->setDescuentos([
                        (new Charge())
                            ->setCodTipo('00')
                            ->setFactor(5.00)
                            ->setMontoBase(100)
                            ->setMonto(5)
                    ])
                    ->setMtoBaseIgv(100)
                    ->setPorcentajeIgv(18)
                    ->setIgv(18)
                    ->setMtoBaseOth(10)
                    ->setPorcentajeOth(100)
                    ->setOtroTributo(10)
                    ->setTotalImpuestos(28)
                    ->setTipAfeIgv('10')
                    ->setMtoValorVenta(100)
                    ->setMtoValorGratuito(2.32)
                    ->setMtoValorUnitario(50.777777)
                    ->setAtributos([
                        (new DetailAttribute())
                        ->setCode('5010')
                        ->setName('Numero de Placa')
                        ->setValue('ABI-453')
                        ,
                        (new DetailAttribute())
                        ->setCode('4005')
                        ->setName('Número de Días de Permanencia')
                        ->setDuracion(5)
                        ,
                        (new DetailAttribute())
                        ->setCode('7014')
                        ->setName('Fecha de inicio/término de vigencia de cobertura')
                        ->setFecInicio(new DateTime())
                        ->setFecFin(new DateTime('+365 days'))
                    ])
            ])->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue('SON N CON 00/100 SOLES')
            ]);

        return $invoice;
    }
}

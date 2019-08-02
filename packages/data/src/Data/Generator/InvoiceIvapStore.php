<?php

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

class InvoiceIvapStore implements DocumentGeneratorInterface
{
    /**
     * @var SharedStore
     */
    private $shared;

    public function __construct(SharedStore $shared)
    {
        $this->shared = $shared;
    }

    public function create()
    {

        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setCompany($this->shared->getCompany())
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoIGV(36)
            ->setTotalImpuestos(36)
            ->setMtoImpVenta(236);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(200.00)
            ->setPorcentajeIgv(18.0)
            ->setIgv(36)
            ->setTotalImpuestos(36)
            ->setTipAfeIgv('17') // IVAP
            ->setMtoValorVenta(200)
            ->setMtoValorUnitario(100)
            ->setMtoPrecioUnitario(118);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails([$detail1])
            ->setLegends([$legend]);

        return $invoice;
    }
}
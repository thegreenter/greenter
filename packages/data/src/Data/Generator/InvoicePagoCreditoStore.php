<?php

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

class InvoicePagoCreditoStore implements DocumentGeneratorInterface
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
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setCompany($this->shared->getCompany())
            ->setFechaEmision(new DateTime('2021-02-06 17:11:20-05:00'))
            ->setFormaPago(new FormaPagoCredito(236))
            ->setCuotas([
                (new Cuota())
                    ->setMonto(100.13)
                    ->setFechaPago(new DateTime('2021-02-13 00:00:00-05:00')),
                (new Cuota())
                    ->setMonto(135.87)
                    ->setFechaPago(new DateTime('2021-02-20 00:00:00-05:00'))
            ])
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoIGV(36)
            ->setTotalImpuestos(36)
            ->setValorVenta(200)
            ->setSubTotal(236)
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
            ->setTipAfeIgv('10')
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

<?php

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

class InvoiceIcbperStore implements DocumentGeneratorInterface
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
            ->setCorrelativo('124')
            ->setCompany($this->shared->getCompany())
            ->setFechaEmision(new DateTime())
            ->setFormaPago(new FormaPagoContado())
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setMtoOperGravadas(200.20)
            ->setMtoIGV(36.04)
            ->setIcbper(0.40)
            ->setTotalImpuestos(36.44)
            ->setValorVenta(200.20)
            ->setSubTotal(236.64)
            ->setMtoImpVenta(236.64);

        $detail = new SaleDetail();
        $detail
            ->setCodProducto('P001')
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

        $detailBolsa = new SaleDetail();
        $detailBolsa
            ->setCodProducto('P002')
            ->setUnidad('NIU')
            ->setCantidad(4)
            ->setDescripcion('BOLSA DE PLASTICO')
            ->setMtoValorUnitario(0.05)
            ->setMtoPrecioUnitario(0.059)
            ->setMtoValorVenta(0.20)
            ->setTipAfeIgv('10')
            ->setMtoBaseIgv(0.20)
            ->setPorcentajeIgv(18.0)
            ->setIgv(0.04)
            ->setTotalImpuestos(0.44)
            ->setIcbper(0.40) // (cantidad)*(factor ICBPER)
            ->setFactorIcbper(0.10)
        ;

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 64/100 SOLES');

        $invoice->setDetails([$detail, $detailBolsa])
            ->setLegends([$legend]);

        return $invoice;
    }
}

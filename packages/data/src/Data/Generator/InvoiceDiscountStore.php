<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:31
 */

namespace Greenter\Data\Generator;

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

class InvoiceDiscountStore implements DocumentGeneratorInterface
{
    /**
     * @var SharedStore
     */
    private $shared;

    public function __construct(SharedStore $shared)
    {
        $this->shared = $shared;
    }

    /**
     * @return DocumentInterface
     * @throws \Exception
     */
    function create()
    {
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setCompany($this->shared->getCompany())
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('124')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setMtoDescuentos(30)
            ->setMtoOperGravadas(70)
            ->setMtoIGV(12.6)
            ->setTotalImpuestos(12.6)
            ->setMtoImpVenta(72.6);

        $detail = new SaleDetail();
        $detail->setCodProducto('C024')
            ->setUnidad('NIU')
            ->setCantidad(1)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100.00)
            ->setPorcentajeIgv(18.0)
            ->setIgv(18)
            ->setTotalImpuestos(18)
            ->setDescuentos([
                (new Charge())
                ->setCodTipo('00')
                ->setFactor(0.30)
                ->setMontoBase(100)
                ->setMonto(30)
            ])
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(100)
            ->setMtoPrecioUnitario(118);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON SETENTA Y DOS CON 60/100 SOLES');

        $invoice->setDetails([$detail])
            ->setLegends([$legend]);

        return $invoice;
    }
}
<?php

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

class BoletaStore implements DocumentGeneratorInterface
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
     * @inheritDoc
     */
    public function create(): ?DocumentInterface
    {
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101')
            ->setTipoDoc('03')
            ->setSerie('B001')
            ->setCorrelativo('1')
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setCompany($this->shared->getCompany())
            ->setClient($this->shared->getClientPerson())
            ->setMtoOperGravadas(100)
            ->setMtoIGV(18)
            ->setTotalImpuestos(18)
            ->setValorVenta(100)
            ->setSubTotal(118)
            ->setMtoImpVenta(118)
        ;

        $item1 = new SaleDetail();
        $item1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18)
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18)
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(59);

        $legend = (new Legend())
            ->setCode('1000')
            ->setValue('SON CIENTO DIECIOCHO CON 00/100 SOLES');

        return $invoice
            ->setDetails([$item1])
            ->setLegends([$legend]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:31
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
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
    public function create(): ?DocumentInterface
    {
        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setCompany($this->shared->getCompany())
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('124')
            ->setFechaEmision(new DateTime())
            ->setFormaPago(new FormaPagoContado())
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setSumOtrosDescuentos(5) // Descuento Global que no afecta a la base imponible
            ->setMtoOperGravadas(70)
            ->setMtoIGV(12.6)
            ->setTotalImpuestos(12.6)
            ->setValorVenta(70)
            ->setSubTotal(72.6)
            ->setRedondeo(0.4)
            ->setMtoImpVenta(68); // SubTotal - descuento global (no afecta base imp.) + redondeo

        $detail = new SaleDetail();
        $detail->setCodProducto('C024')
            ->setUnidad('NIU')
            ->setCantidad(1)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(70.00) // valor venta + isc
            ->setPorcentajeIgv(18.0)
            ->setIgv(12.6)
            ->setTotalImpuestos(12.6)
            ->setDescuentos([
                (new Charge())
                ->setCodTipo('00') // Afecta a la base imponible (catalogo 53)
                ->setFactor(0.30)
                ->setMontoBase(100)
                ->setMonto(30)
            ])
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(70) // (cantidad * valor unitario) - descuentos (cod: 00)
            ->setMtoValorUnitario(100)
            ->setMtoPrecioUnitario(82.6);
        // Precio Unitario (valor venta + total impuestos - descuentos (no afectan base) + cargos (no afectan base)) / cantidad

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON SESENT Y OCHO CON 00/100 SOLES');

        $invoice->setDetails([$detail])
            ->setLegends([$legend]);

        return $invoice;
    }
}

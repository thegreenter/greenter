<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:56
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;

class NoteStore implements DocumentGeneratorInterface
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
        $note = new Note();
        $note
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-111')
            ->setCodMotivo('07')
            ->setDesMotivo('DEVOLUCION POR ITEM')
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setFechaEmision(new DateTime())
            ->setCorrelativo('123')
            ->setTipoMoneda('PEN')
            ->setClient($this->shared->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setTotalImpuestos(36)
            ->setValorVenta(200)
            ->setSubTotal(236)
            ->setMtoImpVenta(236)
            ->setCompany($this->shared->getCompany())
            ->setFormaPago(new FormaPagoContado())
            ->setGuias([(new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-213')
            ]);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 1')
            ->setMtoBaseIgv(100.00)
            ->setPorcentajeIgv(18.0)
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18)
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50.2211133332222)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $note->setDetails([$detail1])
            ->setLegends([$legend]);

        return $note;
    }
}

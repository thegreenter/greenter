<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:59
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Perception\PerceptionDetail;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;

class PerceptionStore implements DocumentGeneratorInterface
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
        $perception = new Perception();
        $perception
            ->setSerie('P001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setObservacion('NOTA EXTRA')
            ->setCompany($this->shared->getCompany())
            ->setProveedor($this->shared->getClient())
            ->setImpPercibido(10)
            ->setImpCobrado(210)
            ->setRegimen('01')
            ->setTasa(2);

        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        $detail = new PerceptionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaPercepcion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpCobrar(210)
            ->setImpPercibido(10)
            ->setCobros([$pay])
            ->setTipoCambio($cambio);

        $detail2 = new PerceptionDetail();
        $detail2->setTipoDoc('01')
            ->setNumDoc('F001-2')
            ->setFechaEmision(new \DateTime())
            ->setFechaPercepcion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(20)
            ->setImpCobrar(21)
            ->setImpPercibido(1);

        $perception->setDetails([$detail, $detail2]);

        return $perception;
    }
}
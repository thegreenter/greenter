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
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Retention\RetentionDetail;

class RetentionStore implements DocumentGeneratorInterface
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
        $retention = new Retention();
        $retention
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->shared->getCompany())
            ->setProveedor($this->shared->getClient())
            ->setObservacion('NOTA EXTRA')
            ->setImpRetenido(10)
            ->setImpPagado(200)
            ->setRegimen('01')
            ->setTasa(3);

        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        $detail = new RetentionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaRetencion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(210)
            ->setImpPagar(200)
            ->setImpRetenido(10)
            ->setPagos([$pay])
            ->setTipoCambio($cambio);

        $retention->setDetails([$detail]);

        return $retention;
    }
}
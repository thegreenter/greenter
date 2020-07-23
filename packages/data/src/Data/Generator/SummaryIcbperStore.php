<?php

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;

class SummaryIcbperStore implements DocumentGeneratorInterface
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
        $detiail = new SummaryDetail();
        $detiail->setTipoDoc('03')
            ->setSerieNro('B001-1')
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(11.9)
            ->setMtoOperGravadas(10)
            ->setMtoOperInafectas(0)
            ->setMtoOperExoneradas(0)
            ->setMtoOperExportacion(0)
            ->setMtoIcbper(0.10)
            ->setMtoIGV(1.8);

        $sum = new Summary();
        $sum->setFecGeneracion(new DateTime('-1days'))
            ->setFecResumen(new DateTime('-1days'))
            ->setCorrelativo('002')
            ->setCompany($this->shared->getCompany())
            ->setDetails([$detiail]);

        return $sum;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:59
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use DateTime;
use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Document;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\SummaryPerception;

class SummaryStore implements DocumentGeneratorInterface
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
        $detiail1 = new SummaryDetail();
        $detiail1->setTipoDoc('03')
            ->setSerieNro('B001-1')
            ->setEstado('3')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoOperExportacion(10)
            ->setMtoOtrosCargos(21)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetail();
        $detiail2->setTipoDoc('07')
            ->setSerieNro('B001-4')
            ->setDocReferencia((new Document())
                ->setTipoDoc('03')
                ->setNroDoc('0001-122'))
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(200)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoOperGratuitas(10)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $detiail3 = new SummaryDetail();
        $detiail3->setTipoDoc('03')
            ->setSerieNro('B001-2')
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setPercepcion((new SummaryPerception())
                ->setCodReg('01')
                ->setTasa(2.00)
                ->setMtoBase(100.00)
                ->setMto(2.00)
                ->setMtoTotal(102.00))
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoOtrosCargos(21)
            ->setMtoIGV(3.6);

        $detiail4 = new SummaryDetail();
        $detiail4->setTipoDoc('03')
            ->setSerieNro('B001-3')
            ->setEstado('1')
            ->setClienteTipo('1')
            ->setClienteNro('00000000')
            ->setTotal(104)
            ->setMtoOperGravadas(100)
            ->setMtoIvap(4);

        $sum = new Summary();
        $sum->setFecGeneracion(new DateTime('-1days'))
            ->setFecResumen(new DateTime('-1days'))
            ->setCorrelativo('001')
            ->setCompany($this->shared->getCompany())
            ->setDetails([$detiail1, $detiail2, $detiail3]);

        return $sum;
    }
}
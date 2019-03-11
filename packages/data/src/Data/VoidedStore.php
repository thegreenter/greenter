<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 21:59
 */

namespace Greenter\Data;

use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;

class VoidedStore
{
    /**
     * @var SharedStore
     */
    private $shared;

    public function __construct(SharedStore $shared)
    {
        $this->shared = $shared;
    }

    public function getVoided()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('07')
            ->setSerie('FC01')
            ->setCorrelativo('222')
            ->setDesMotivoBaja('ERROR DE RUC');

        $voided = new Voided();
        $voided->setCorrelativo('00111')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setCompany($this->shared->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $voided;
    }

    public function getReversion()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setCompany($this->shared->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }
}
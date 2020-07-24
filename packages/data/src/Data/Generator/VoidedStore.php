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
use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;

class VoidedStore implements DocumentGeneratorInterface
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
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMÁ');

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
}
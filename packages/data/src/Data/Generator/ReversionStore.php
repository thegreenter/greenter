<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:14
 */

declare(strict_types=1);

namespace Greenter\Data\Generator;

use Greenter\Data\DocumentGeneratorInterface;
use Greenter\Data\SharedStore;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;

class ReversionStore implements DocumentGeneratorInterface
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
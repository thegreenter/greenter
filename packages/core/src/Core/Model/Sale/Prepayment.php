<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/09/2017
 * Time: 08:21 PM.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Class Prepayment.
 */
class Prepayment
{
    /**
     * @var string
     */
    private $tipoDocRel;

    /**
     * @var string
     */
    private $nroDocRel;

    /**
     * @var float
     */
    private $total;

    /**
     * @return string
     */
    public function getTipoDocRel(): ?string
    {
        return $this->tipoDocRel;
    }

    /**
     * @param string $tipoDocRel
     *
     * @return Prepayment
     */
    public function setTipoDocRel(?string $tipoDocRel): Prepayment
    {
        $this->tipoDocRel = $tipoDocRel;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroDocRel(): ?string
    {
        return $this->nroDocRel;
    }

    /**
     * @param string $nroDocRel
     *
     * @return Prepayment
     */
    public function setNroDocRel(?string $nroDocRel): Prepayment
    {
        $this->nroDocRel = $nroDocRel;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float $total
     *
     * @return Prepayment
     */
    public function setTotal(?float $total): Prepayment
    {
        $this->total = $total;

        return $this;
    }
}

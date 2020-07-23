<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:10.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Class SalePerception.
 */
class SalePerception
{
    /**
     * @var string
     */
    private $codReg;

    /**
     * @var float
     */
    private $porcentaje;

    /**
     * @var float
     */
    private $mtoBase;

    /**
     * @var float
     */
    private $mto;

    /**
     * @var float
     */
    private $mtoTotal;

    /**
     * @return string
     */
    public function getCodReg(): ?string
    {
        return $this->codReg;
    }

    /**
     * @param string $codReg
     *
     * @return SalePerception
     */
    public function setCodReg(?string $codReg): SalePerception
    {
        $this->codReg = $codReg;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentaje(): ?float
    {
        return $this->porcentaje;
    }

    /**
     * @param float $porcentaje
     *
     * @return SalePerception
     */
    public function setPorcentaje(?float $porcentaje): SalePerception
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBase(): ?float
    {
        return $this->mtoBase;
    }

    /**
     * @param float $mtoBase
     *
     * @return SalePerception
     */
    public function setMtoBase(?float $mtoBase): SalePerception
    {
        $this->mtoBase = $mtoBase;

        return $this;
    }

    /**
     * @return float
     */
    public function getMto(): ?float
    {
        return $this->mto;
    }

    /**
     * @param float $mto
     *
     * @return SalePerception
     */
    public function setMto(?float $mto): SalePerception
    {
        $this->mto = $mto;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoTotal(): ?float
    {
        return $this->mtoTotal;
    }

    /**
     * @param float $mtoTotal
     *
     * @return SalePerception
     */
    public function setMtoTotal(?float $mtoTotal): SalePerception
    {
        $this->mtoTotal = $mtoTotal;

        return $this;
    }
}

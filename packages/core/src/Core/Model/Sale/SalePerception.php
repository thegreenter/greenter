<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:10.
 */

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
    public function getCodReg()
    {
        return $this->codReg;
    }

    /**
     * @param string $codReg
     *
     * @return SalePerception
     */
    public function setCodReg($codReg)
    {
        $this->codReg = $codReg;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * @param float $porcentaje
     * @return SalePerception
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBase()
    {
        return $this->mtoBase;
    }

    /**
     * @param float $mtoBase
     *
     * @return SalePerception
     */
    public function setMtoBase($mtoBase)
    {
        $this->mtoBase = $mtoBase;

        return $this;
    }

    /**
     * @return float
     */
    public function getMto()
    {
        return $this->mto;
    }

    /**
     * @param float $mto
     *
     * @return SalePerception
     */
    public function setMto($mto)
    {
        $this->mto = $mto;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoTotal()
    {
        return $this->mtoTotal;
    }

    /**
     * @param float $mtoTotal
     *
     * @return SalePerception
     */
    public function setMtoTotal($mtoTotal)
    {
        $this->mtoTotal = $mtoTotal;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 04/10/2018
 * Time: 23:03
 */

namespace Greenter\Model\Sale;

/**
 * Class Charge.
 */
class Charge
{
    /**
     * @var string
     */
    private $codTipo;
    /**
     * @var string
     */
    private $factor;
    /**
     * @var float
     */
    private $monto;
    /**
     * @var float
     */
    private $montoBase;

    /**
     * @return string
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * @param string $codTipo
     * @return Charge
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * @param string $factor
     * @return Charge
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;
        return $this;
    }

    /**
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param float $monto
     * @return Charge
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
        return $this;
    }

    /**
     * @return float
     */
    public function getMontoBase()
    {
        return $this->montoBase;
    }

    /**
     * @param float $montoBase
     * @return Charge
     */
    public function setMontoBase($montoBase)
    {
        $this->montoBase = $montoBase;
        return $this;
    }
}
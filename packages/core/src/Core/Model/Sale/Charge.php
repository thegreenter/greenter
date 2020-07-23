<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 04/10/2018
 * Time: 23:03.
 */

declare(strict_types=1);

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
     * @var float
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
    public function getCodTipo(): ?string
    {
        return $this->codTipo;
    }

    /**
     * @param string $codTipo
     *
     * @return Charge
     */
    public function setCodTipo(?string $codTipo): Charge
    {
        $this->codTipo = $codTipo;

        return $this;
    }

    /**
     * @return float
     */
    public function getFactor(): ?float
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     *
     * @return Charge
     */
    public function setFactor(?float $factor): Charge
    {
        $this->factor = $factor;

        return $this;
    }

    /**
     * @return float
     */
    public function getMonto(): ?float
    {
        return $this->monto;
    }

    /**
     * @param float $monto
     *
     * @return Charge
     */
    public function setMonto(?float $monto): Charge
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * @return float
     */
    public function getMontoBase(): ?float
    {
        return $this->montoBase;
    }

    /**
     * @param float $montoBase
     *
     * @return Charge
     */
    public function setMontoBase(?float $montoBase): Charge
    {
        $this->montoBase = $montoBase;

        return $this;
    }
}

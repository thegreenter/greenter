<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/11/2017
 * Time: 19:37.
 */

declare(strict_types=1);

namespace Greenter\Model\Summary;

/**
 * Class SummaryPerception
 * Perception for Summary.
 */
class SummaryPerception
{
    /**
     * Tasa de la percepción.
     *
     * @var string
     */
    private $codReg;

    /**
     * Tasa de la percepción.
     *
     * @var float
     */
    private $tasa;

    /**
     * Base imponible percepción.
     *
     * @var float
     */
    private $mtoBase;

    /**
     * Monto de la percepción.
     *
     * @var float
     */
    private $mto;

    /**
     * Monto total a cobrar incluida la percepción.
     *
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
     * @return SummaryPerception
     */
    public function setCodReg(?string $codReg): SummaryPerception
    {
        $this->codReg = $codReg;

        return $this;
    }

    /**
     * @return float
     */
    public function getTasa(): ?float
    {
        return $this->tasa;
    }

    /**
     * @param float $tasa
     *
     * @return SummaryPerception
     */
    public function setTasa(?float $tasa): SummaryPerception
    {
        $this->tasa = $tasa;

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
     * @return SummaryPerception
     */
    public function setMtoBase(?float $mtoBase): SummaryPerception
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
     * @return SummaryPerception
     */
    public function setMto(?float $mto): SummaryPerception
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
     * @return SummaryPerception
     */
    public function setMtoTotal(?float $mtoTotal): SummaryPerception
    {
        $this->mtoTotal = $mtoTotal;

        return $this;
    }
}

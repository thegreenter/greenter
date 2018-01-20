<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/11/2017
 * Time: 19:37.
 */

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
    public function getCodReg()
    {
        return $this->codReg;
    }

    /**
     * @param string $codReg
     *
     * @return SummaryPerception
     */
    public function setCodReg($codReg)
    {
        $this->codReg = $codReg;

        return $this;
    }

    /**
     * @return float
     */
    public function getTasa()
    {
        return $this->tasa;
    }

    /**
     * @param float $tasa
     *
     * @return SummaryPerception
     */
    public function setTasa($tasa)
    {
        $this->tasa = $tasa;

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
     * @return SummaryPerception
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
     * @return SummaryPerception
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
     * @return SummaryPerception
     */
    public function setMtoTotal($mtoTotal)
    {
        $this->mtoTotal = $mtoTotal;

        return $this;
    }
}

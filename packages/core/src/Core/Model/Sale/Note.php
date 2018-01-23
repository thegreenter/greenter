<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:51.
 */

namespace Greenter\Model\Sale;

/**
 * Class Note.
 */
class Note extends BaseSale
{
    /**
     * @var string
     */
    private $codMotivo;

    /**
     * @var string
     */
    private $desMotivo;

    /**
     * @var string
     */
    private $tipDocAfectado;

    /**
     * @var string
     */
    private $numDocfectado;

    /**
     * @var float
     */
    private $mtoOperGratuitas;

    /**
     * @var SalePerception
     */
    private $perception;

    /**
     * @return string
     */
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * @param string $codMotivo
     *
     * @return Note
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesMotivo()
    {
        return $this->desMotivo;
    }

    /**
     * @param string $desMotivo
     *
     * @return Note
     */
    public function setDesMotivo($desMotivo)
    {
        $this->desMotivo = $desMotivo;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipDocAfectado()
    {
        return $this->tipDocAfectado;
    }

    /**
     * @param string $tipDocAfectado
     *
     * @return Note
     */
    public function setTipDocAfectado($tipDocAfectado)
    {
        $this->tipDocAfectado = $tipDocAfectado;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDocfectado()
    {
        return $this->numDocfectado;
    }

    /**
     * @param string $numDocfectado
     *
     * @return Note
     */
    public function setNumDocfectado($numDocfectado)
    {
        $this->numDocfectado = $numDocfectado;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGratuitas()
    {
        return $this->mtoOperGratuitas;
    }

    /**
     * @param float $mtoOperGratuitas
     *
     * @return Note
     */
    public function setMtoOperGratuitas($mtoOperGratuitas)
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;

        return $this;
    }

    /**
     * @return SalePerception
     */
    public function getPerception()
    {
        return $this->perception;
    }

    /**
     * @param SalePerception $perception
     *
     * @return Note
     */
    public function setPerception($perception)
    {
        $this->perception = $perception;

        return $this;
    }
}

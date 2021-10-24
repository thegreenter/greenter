<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:51.
 */

declare(strict_types=1);

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
     * @var SalePerception
     */
    private $perception;

    /**
     * @var float
     */
    private $sumDsctoGlobal;

    /**
     * @var float
     */
    private $mtoDescuentos;

    /**
     * @var Charge[]
     */
    private $descuentos;

    /**
     * @return string
     */
    public function getCodMotivo(): ?string
    {
        return $this->codMotivo;
    }

    /**
     * @param string $codMotivo
     *
     * @return Note
     */
    public function setCodMotivo(?string $codMotivo): Note
    {
        $this->codMotivo = $codMotivo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesMotivo(): ?string
    {
        return $this->desMotivo;
    }

    /**
     * @param string $desMotivo
     *
     * @return Note
     */
    public function setDesMotivo(?string $desMotivo): Note
    {
        $this->desMotivo = $desMotivo;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipDocAfectado(): ?string
    {
        return $this->tipDocAfectado;
    }

    /**
     * @param string $tipDocAfectado
     *
     * @return Note
     */
    public function setTipDocAfectado(?string $tipDocAfectado): Note
    {
        $this->tipDocAfectado = $tipDocAfectado;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDocfectado(): ?string
    {
        return $this->numDocfectado;
    }

    /**
     * @param string $numDocfectado
     *
     * @return Note
     */
    public function setNumDocfectado(?string $numDocfectado): Note
    {
        $this->numDocfectado = $numDocfectado;

        return $this;
    }

    /**
     * @return SalePerception
     */
    public function getPerception(): ?SalePerception
    {
        return $this->perception;
    }

    /**
     * @param SalePerception $perception
     *
     * @return Note
     */
    public function setPerception(?SalePerception $perception): Note
    {
        $this->perception = $perception;

        return $this;
    }

    /**
     * @return float
     */
    public function getSumDsctoGlobal(): ?float
    {
        return $this->sumDsctoGlobal;
    }

    /**
     * @param float $sumDsctoGlobal
     *
     * @return Note
     */
    public function setSumDsctoGlobal(?float $sumDsctoGlobal): Note
    {
        $this->sumDsctoGlobal = $sumDsctoGlobal;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoDescuentos(): ?float
    {
        return $this->mtoDescuentos;
    }

    /**
     * @param float $mtoDescuentos
     *
     * @return Note
     */
    public function setMtoDescuentos(?float $mtoDescuentos): Note
    {
        $this->mtoDescuentos = $mtoDescuentos;

        return $this;
    }

    /**
     * @return Charge[]
     */
    public function getDescuentos(): ?array
    {
        return $this->descuentos;
    }

    /**
     * @param Charge[] $descuentos
     *
     * @return Note
     */
    public function setDescuentos(?array $descuentos): Note
    {
        $this->descuentos = $descuentos;

        return $this;
    }
}

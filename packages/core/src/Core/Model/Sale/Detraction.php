<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Class Detraction.
 */
class Detraction
{
    /**
     * Porcentaje de la detracción.
     *
     * @var float
     */
    private $percent;

    /**
     * Monto de la detracción.
     *
     * @var float
     */
    private $mount;

    /**
     * @var string
     */
    private $ctaBanco;

    /**
     * @var string
     */
    private $codMedioPago;

    /**
     * @var string
     */
    private $codBienDetraccion;

    /**
     * Valor referencial, en el caso de detracciones
     * al transporte de bienes por vía terrestre.
     *
     * @var float
     */
    private $valueRef;

    /**
     * @return float
     */
    public function getPercent(): ?float
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     *
     * @return Detraction
     */
    public function setPercent(?float $percent): Detraction
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * @return float
     */
    public function getMount(): ?float
    {
        return $this->mount;
    }

    /**
     * @param float $mount
     *
     * @return Detraction
     */
    public function setMount(?float $mount): Detraction
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCtaBanco(): ?string
    {
        return $this->ctaBanco;
    }

    /**
     * @param string $ctaBanco
     *
     * @return Detraction
     */
    public function setCtaBanco(?string $ctaBanco): Detraction
    {
        $this->ctaBanco = $ctaBanco;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodMedioPago(): ?string
    {
        return $this->codMedioPago;
    }

    /**
     * @param string $codMedioPago
     *
     * @return Detraction
     */
    public function setCodMedioPago(?string $codMedioPago): Detraction
    {
        $this->codMedioPago = $codMedioPago;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodBienDetraccion(): ?string
    {
        return $this->codBienDetraccion;
    }

    /**
     * @param string $codBienDetraccion
     *
     * @return Detraction
     */
    public function setCodBienDetraccion(?string $codBienDetraccion): Detraction
    {
        $this->codBienDetraccion = $codBienDetraccion;

        return $this;
    }

    /**
     * @return float
     */
    public function getValueRef(): ?float
    {
        return $this->valueRef;
    }

    /**
     * @param float $valueRef
     *
     * @return Detraction
     */
    public function setValueRef(?float $valueRef): Detraction
    {
        $this->valueRef = $valueRef;

        return $this;
    }
}

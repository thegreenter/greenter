<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

use DateTimeInterface;

class Cuota
{
    /**
     * @var string|null
     */
    private $moneda;

    /**
     * @var float|null
     */
    private $monto;

    /**
     * @var DateTimeInterface|null
     */
    private $fechaPago;

    /**
     * @return string|null
     */
    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    /**
     * @param string|null $moneda
     * @return $this
     */
    public function setMoneda(?string $moneda): self
    {
        $this->moneda = $moneda;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getMonto(): ?float
    {
        return $this->monto;
    }

    /**
     * @param float|null $monto
     * @return $this
     */
    public function setMonto(?float $monto): self
    {
        $this->monto = $monto;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getFechaPago(): ?DateTimeInterface
    {
        return $this->fechaPago;
    }

    /**
     * @param DateTimeInterface|null $fechaPago
     * @return $this
     */
    public function setFechaPago(?DateTimeInterface $fechaPago): self
    {
        $this->fechaPago = $fechaPago;
        return $this;
    }
}
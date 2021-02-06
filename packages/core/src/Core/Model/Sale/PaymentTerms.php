<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

class PaymentTerms
{
    /**
     * @var string|null
     */
    protected $moneda;

    /**
     * @var string|null
     */
    protected $tipo;

    /**
     * @var float|null
     */
    protected $monto;

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
     * @return string|null
     */
    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    /**
     * @param string|null $tipo
     * @return $this
     */
    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;
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
}
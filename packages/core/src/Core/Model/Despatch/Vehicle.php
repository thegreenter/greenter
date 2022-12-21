<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

class Vehicle
{
    /**
     * @var string
     */
    private $placa;
    /**
     * @var string
     */
    private $nroCirculacion;
    /**
     * @var string
     */
    private $codEmisor;
    /**
     * @var string
     */
    private $nroAutorizacion;
    /**
     * @var Vehicle[]
     */
    private $secundarios;

    /**
     * @return string
     */
    public function getPlaca(): ?string
    {
        return $this->placa;
    }

    /**
     * @param string|null $placa
     * @return Vehicle
     */
    public function setPlaca(?string $placa): Vehicle
    {
        $this->placa = $placa;
        return $this;
    }

    /**
     * @return string
     */
    public function getNroCirculacion(): ?string
    {
        return $this->nroCirculacion;
    }

    /**
     * @param string|null $nroCirculacion
     * @return Vehicle
     */
    public function setNroCirculacion(?string $nroCirculacion): Vehicle
    {
        $this->nroCirculacion = $nroCirculacion;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodEmisor(): ?string
    {
        return $this->codEmisor;
    }

    /**
     * @param string|null $codEmisor
     * @return Vehicle
     */
    public function setCodEmisor(?string $codEmisor): Vehicle
    {
        $this->codEmisor = $codEmisor;
        return $this;
    }

    /**
     * @return string
     */
    public function getNroAutorizacion(): ?string
    {
        return $this->nroAutorizacion;
    }

    /**
     * @param string|null $nroAutorizacion
     * @return Vehicle
     */
    public function setNroAutorizacion(?string $nroAutorizacion): Vehicle
    {
        $this->nroAutorizacion = $nroAutorizacion;
        return $this;
    }

    /**
     * @return Vehicle[]
     */
    public function getSecundarios(): ?array
    {
        return $this->secundarios;
    }

    /**
     * @param Vehicle[] $secundarios
     * @return Vehicle
     */
    public function setSecundarios(?array $secundarios): Vehicle
    {
        $this->secundarios = $secundarios;
        return $this;
    }
}
<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

class Driver
{
    /**
     * Tipo de Conductor (Principal o Secundario).
     *
     * @var string
     */
    private $tipo;
    /**
     * @var string
     */
    private $tipoDoc;
    /**
     * @var string
     */
    private $nroDoc;
    /**
     * @var string
     */
    private $nombres;
    /**
     * @var string
     */
    private $apellidos;
    /**
     * @var string
     */
    private $licencia;

    /**
     * @return string
     */
    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    /**
     * @param string|null $tipo
     * @return Driver
     */
    public function setTipo(?string $tipo): Driver
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string|null $tipoDoc
     * @return Driver
     */
    public function setTipoDoc(?string $tipoDoc): Driver
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNroDoc(): ?string
    {
        return $this->nroDoc;
    }

    /**
     * @param string|null $nroDoc
     * @return Driver
     */
    public function setNroDoc(?string $nroDoc): Driver
    {
        $this->nroDoc = $nroDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    /**
     * @param string|null $nombres
     * @return Driver
     */
    public function setNombres(?string $nombres): Driver
    {
        $this->nombres = $nombres;
        return $this;
    }

    /**
     * @return string
     */
    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    /**
     * @param string|null $apellidos
     * @return Driver
     */
    public function setApellidos(?string $apellidos): Driver
    {
        $this->apellidos = $apellidos;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicencia(): ?string
    {
        return $this->licencia;
    }

    /**
     * @param string|null $licencia
     * @return Driver
     */
    public function setLicencia(?string $licencia): Driver
    {
        $this->licencia = $licencia;
        return $this;
    }
}
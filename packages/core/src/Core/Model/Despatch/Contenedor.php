<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Un contenedor de la guía y su precinto (campos 28 a 31 de «Guía-Remitente2_0»,
 * cac:TransportHandlingUnit/cac:Package).
 */
class Contenedor
{
    /**
     * Número de contenedor (cbc:ID), an..17.
     *
     * @var string|null
     */
    private $numero;

    /**
     * Número de precinto (cbc:TraceID), an..100.
     *
     * @var string|null
     */
    private $precinto;

    /**
     * @return string|null
     */
    public function getNumero(): ?string
    {
        return $this->numero;
    }

    /**
     * @param string|null $numero
     *
     * @return Contenedor
     */
    public function setNumero(?string $numero): Contenedor
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrecinto(): ?string
    {
        return $this->precinto;
    }

    /**
     * @param string|null $precinto
     *
     * @return Contenedor
     */
    public function setPrecinto(?string $precinto): Contenedor
    {
        $this->precinto = $precinto;

        return $this;
    }
}

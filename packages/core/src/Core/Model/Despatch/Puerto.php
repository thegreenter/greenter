<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

class Puerto
{
    /**
     * Código del Puerto/Aeropuerto.
     *
     * @var string
     */
    private $codigo;
    /**
     * Nombre del puerto o aeropuerto.
     *
     * @var string
     */
    private $nombre;

    /**
     * @return string
     */
    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    /**
     * @param string|null $codigo
     * @return Puerto
     */
    public function setCodigo(?string $codigo): Puerto
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * @param string|null $nombre
     * @return Puerto
     */
    public function setNombre(?string $nombre): Puerto
    {
        $this->nombre = $nombre;
        return $this;
    }
}
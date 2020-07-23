<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:56.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Class Direction.
 */
class Direction
{
    /**
     * @var string
     */
    private $ubigueo;

    /**
     * Direccion completa y detallada.
     *
     * @var string
     */
    private $direccion;

    /**
     * Direction constructor.
     *
     * @param string|null $ubigueo
     * @param string|null $direccion
     */
    public function __construct(?string $ubigueo, ?string $direccion)
    {
        $this->ubigueo = $ubigueo;
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getUbigueo(): ?string
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
     *
     * @return Direction
     */
    public function setUbigueo(?string $ubigueo): Direction
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     *
     * @return Direction
     */
    public function setDireccion(?string $direccion): Direction
    {
        $this->direccion = $direccion;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:56.
 */

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
     * @param string $ubigueo
     * @param string $direccion
     */
    public function __construct($ubigueo, $direccion)
    {
        $this->ubigueo = $ubigueo;
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getUbigueo()
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
     *
     * @return Direction
     */
    public function setUbigueo($ubigueo)
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     *
     * @return Direction
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }
}

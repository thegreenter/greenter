<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:56
 */

namespace Greenter\Model\Despatch;

use Greenter\Xml\Validator\DirectionValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Direction
 * @package Greenter\Model\Despatch
 */
class Direction
{
    use DirectionValidator;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    private $ubigueo;

    /**
     * Direccion completa y detallada.
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    private $direccion;

    /**
     * @return string
     */
    public function getUbigueo()
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
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
     * @return Direction
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }
}
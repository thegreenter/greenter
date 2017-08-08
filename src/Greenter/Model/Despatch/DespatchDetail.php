<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42
 */

namespace Greenter\Model\Despatch;

use Greenter\Xml\Validator\DespatchDetailValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DespatchDetail
 * @package Greenter\Model\Despatch
 */
class DespatchDetail
{
    use DespatchDetailValidator;

    /**
     * @Assert\Length(max="16")
     * @var string
     */
    private $codigo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="250")
     * @var string
     */
    private $descripcion;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="4")
     * @var string
     */
    private $unidad;

    /**
     * @Assert\NotBlank()
     * @var int
     */
    private $cantidad;

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     * @return DespatchDetail
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return DespatchDetail
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * @param string $unidad
     * @return DespatchDetail
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;
        return $this;
    }

    /**
     * @return int
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     * @return DespatchDetail
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
        return $this;
    }
}
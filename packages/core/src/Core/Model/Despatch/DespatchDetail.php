<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42.
 */

namespace Greenter\Model\Despatch;

/**
 * Class DespatchDetail.
 */
class DespatchDetail
{
    /**
     * @var string
     */
    private $codigo;
    /**
     * @var string
     */
    private $descripcion;
    /**
     * @var string
     */
    private $unidad;
    /**
     * @var float
     */
    private $cantidad;
    /**
     * Codigo de Producto - SUNAT.
     *
     * @var string
     */
    private $codProdSunat;

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     *
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
     *
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
     *
     * @return DespatchDetail
     */
    public function setUnidad($unidad)
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * @return float
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     *
     * @return DespatchDetail
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodProdSunat()
    {
        return $this->codProdSunat;
    }

    /**
     * @param string $codProdSunat
     *
     * @return DespatchDetail
     */
    public function setCodProdSunat($codProdSunat)
    {
        $this->codProdSunat = $codProdSunat;

        return $this;
    }
}

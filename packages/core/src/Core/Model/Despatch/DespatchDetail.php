<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

use Greenter\Model\Sale\DetailAttribute;

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
     * Código GTIN del bien (cac:StandardItemIdentification/cbc:ID): de 8, 12, 13 o 14 caracteres.
     *
     * @var string|null
     */
    private $codProdGS1;

    /**
     * @var DetailAttribute[]
     */
    private $atributos;

    /**
     * @return string
     */
    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     *
     * @return DespatchDetail
     */
    public function setCodigo(?string $codigo): DespatchDetail
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     *
     * @return DespatchDetail
     */
    public function setDescripcion(?string $descripcion): DespatchDetail
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return string
     */
    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    /**
     * @param string $unidad
     *
     * @return DespatchDetail
     */
    public function setUnidad(?string $unidad): DespatchDetail
    {
        $this->unidad = $unidad;

        return $this;
    }

    /**
     * @return float
     */
    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     *
     * @return DespatchDetail
     */
    public function setCantidad(?float $cantidad): DespatchDetail
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodProdSunat(): ?string
    {
        return $this->codProdSunat;
    }

    /**
     * @param string $codProdSunat
     *
     * @return DespatchDetail
     */
    public function setCodProdSunat(?string $codProdSunat): DespatchDetail
    {
        $this->codProdSunat = $codProdSunat;

        return $this;
    }

    /**
     * @return DetailAttribute[]
     */
    public function getAtributos(): ?array
    {
        return $this->atributos;
    }

    /**
     * @param DetailAttribute[] $atributos
     * @return DespatchDetail
     */
    public function setAtributos(?array $atributos): DespatchDetail
    {
        $this->atributos = $atributos;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodProdGS1(): ?string
    {
        return $this->codProdGS1;
    }

    /**
     * @param string|null $codProdGS1
     *
     * @return DespatchDetail
     */
    public function setCodProdGS1(?string $codProdGS1): DespatchDetail
    {
        $this->codProdGS1 = $codProdGS1;

        return $this;
    }
}

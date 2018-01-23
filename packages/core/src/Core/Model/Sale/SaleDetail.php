<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05.
 */

namespace Greenter\Model\Sale;

/**
 * Class SaleDetail.
 */
class SaleDetail
{
    /**
     * Codigo unidad de Medida.
     *
     * @var string
     */
    private $unidad;
    /**
     * Cantidad de unidades por ítem.
     *
     * @var float
     */
    private $cantidad;

    /**
     * @var string
     */
    private $codProducto;

    /**
     * Codigo de Producto - SUNAT.
     *
     * @var string
     */
    private $codProdSunat;

    /**
     * Descripcion del Producto.
     *
     * @var string
     */
    private $descripcion;

    /**
     * Monto del valor unitario (PrecioUnitario SIN IGV).
     *
     * @var float
     */
    private $mtoValorUnitario;

    /**
     * @var float
     */
    private $descuento;

    /**
     * @var float
     */
    private $igv;

    /**
     * @var string
     */
    private $tipAfeIgv;

    /**
     * @var float
     */
    private $isc;

    /**
     * @var string
     */
    private $tipSisIsc;

    /**
     * Precio de venta unitario por item.
     *
     * @var float
     */
    private $mtoPrecioUnitario;

    /**
     * Valor de venta por ítem. (Total).
     *
     * @var float
     */
    private $mtoValorVenta;

    /**
     * Valor referencial unitario por ítem en operaciones no onerosas (gratuita).
     *
     * @var float
     */
    private $mtoValorGratuito;

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
     * @return SaleDetail
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
     * @return SaleDetail
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodProducto()
    {
        return $this->codProducto;
    }

    /**
     * @param string $codProducto
     *
     * @return SaleDetail
     */
    public function setCodProducto($codProducto)
    {
        $this->codProducto = $codProducto;

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
     * @return SaleDetail
     */
    public function setCodProdSunat($codProdSunat)
    {
        $this->codProdSunat = $codProdSunat;

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
     * @return SaleDetail
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorUnitario()
    {
        return $this->mtoValorUnitario;
    }

    /**
     * @param float $mtoValorUnitario
     *
     * @return SaleDetail
     */
    public function setMtoValorUnitario($mtoValorUnitario)
    {
        $this->mtoValorUnitario = $mtoValorUnitario;

        return $this;
    }

    /**
     * @return float
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * @param float $descuento
     *
     * @return SaleDetail
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * @return float
     */
    public function getIgv()
    {
        return $this->igv;
    }

    /**
     * @param float $igv
     *
     * @return SaleDetail
     */
    public function setIgv($igv)
    {
        $this->igv = $igv;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipAfeIgv()
    {
        return $this->tipAfeIgv;
    }

    /**
     * @param string $tipAfeIgv
     *
     * @return SaleDetail
     */
    public function setTipAfeIgv($tipAfeIgv)
    {
        $this->tipAfeIgv = $tipAfeIgv;

        return $this;
    }

    /**
     * @return float
     */
    public function getIsc()
    {
        return $this->isc;
    }

    /**
     * @param float $isc
     *
     * @return SaleDetail
     */
    public function setIsc($isc)
    {
        $this->isc = $isc;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipSisIsc()
    {
        return $this->tipSisIsc;
    }

    /**
     * @param string $tipSisIsc
     *
     * @return SaleDetail
     */
    public function setTipSisIsc($tipSisIsc)
    {
        $this->tipSisIsc = $tipSisIsc;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoPrecioUnitario()
    {
        return $this->mtoPrecioUnitario;
    }

    /**
     * @param float $mtoPrecioUnitario
     *
     * @return SaleDetail
     */
    public function setMtoPrecioUnitario($mtoPrecioUnitario)
    {
        $this->mtoPrecioUnitario = $mtoPrecioUnitario;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorVenta()
    {
        return $this->mtoValorVenta;
    }

    /**
     * @param float $mtoValorVenta
     *
     * @return SaleDetail
     */
    public function setMtoValorVenta($mtoValorVenta)
    {
        $this->mtoValorVenta = $mtoValorVenta;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorGratuito()
    {
        return $this->mtoValorGratuito;
    }

    /**
     * @param float $mtoValorGratuito
     *
     * @return SaleDetail
     */
    public function setMtoValorGratuito($mtoValorGratuito)
    {
        $this->mtoValorGratuito = $mtoValorGratuito;

        return $this;
    }
}

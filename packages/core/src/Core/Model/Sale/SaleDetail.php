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
     * Código de producto GS1.
     *
     * @var string
     */
    private $codProdGS1;

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
     * @var Charge[]
     */
    private $cargos;
    /**
     * @var Charge[]
     */
    private $descuentos;
    /**
     * @var float
     */
    private $descuento;

    /**
     * @var float
     */
    private $mtoBaseIgv;

    /**
     * @var float
     */
    private $porcentajeIgv;

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
    private $mtoBaseIsc;

    /**
     * @var float
     */
    private $porcentajeIsc;
    /**
     * @var float
     */
    private $isc;

    /**
     * @var string
     */
    private $tipSisIsc;

    /**
     * @var float
     */
    private $mtoBaseOth;
    /**
     * @var float
     */
    private $porcentajeOth;
    /**
     * @var float
     */
    private $otroTributo;
    /**
     * @var float
     */
    private $totalImpuestos;

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
     * @var DetailAttribute[]
     */
    private $atributos;

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
    public function getCodProdGS1()
    {
        return $this->codProdGS1;
    }

    /**
     * @param string $codProdGS1
     * @return SaleDetail
     */
    public function setCodProdGS1($codProdGS1)
    {
        $this->codProdGS1 = $codProdGS1;
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
     * @deprecated UBL 2.1
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
    public function getTotalImpuestos()
    {
        return $this->totalImpuestos;
    }

    /**
     * @param float $totalImpuestos
     * @return SaleDetail
     */
    public function setTotalImpuestos($totalImpuestos)
    {
        $this->totalImpuestos = $totalImpuestos;
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

    /**
     * @return float
     */
    public function getMtoBaseIgv()
    {
        return $this->mtoBaseIgv;
    }

    /**
     * @param float $mtoBaseIgv
     * @return SaleDetail
     */
    public function setMtoBaseIgv($mtoBaseIgv)
    {
        $this->mtoBaseIgv = $mtoBaseIgv;
        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeIgv()
    {
        return $this->porcentajeIgv;
    }

    /**
     * @param float $porcentajeIgv
     * @return SaleDetail
     */
    public function setPorcentajeIgv($porcentajeIgv)
    {
        $this->porcentajeIgv = $porcentajeIgv;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIsc()
    {
        return $this->mtoBaseIsc;
    }

    /**
     * @param float $mtoBaseIsc
     * @return SaleDetail
     */
    public function setMtoBaseIsc($mtoBaseIsc)
    {
        $this->mtoBaseIsc = $mtoBaseIsc;
        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeIsc()
    {
        return $this->porcentajeIsc;
    }

    /**
     * @param float $porcentajeIsc
     * @return SaleDetail
     */
    public function setPorcentajeIsc($porcentajeIsc)
    {
        $this->porcentajeIsc = $porcentajeIsc;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseOth()
    {
        return $this->mtoBaseOth;
    }

    /**
     * @param float $mtoBaseOth
     * @return SaleDetail
     */
    public function setMtoBaseOth($mtoBaseOth)
    {
        $this->mtoBaseOth = $mtoBaseOth;
        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeOth()
    {
        return $this->porcentajeOth;
    }

    /**
     * @param float $porcentajeOth
     * @return SaleDetail
     */
    public function setPorcentajeOth($porcentajeOth)
    {
        $this->porcentajeOth = $porcentajeOth;
        return $this;
    }

    /**
     * @return float
     */
    public function getOtroTributo()
    {
        return $this->otroTributo;
    }

    /**
     * @param float $otroTributo
     * @return SaleDetail
     */
    public function setOtroTributo($otroTributo)
    {
        $this->otroTributo = $otroTributo;
        return $this;
    }

    /**
     * @return Charge[]
     */
    public function getCargos()
    {
        return $this->cargos;
    }

    /**
     * @param Charge[] $cargos
     * @return SaleDetail
     */
    public function setCargos($cargos)
    {
        $this->cargos = $cargos;
        return $this;
    }

    /**
     * @return Charge[]
     */
    public function getDescuentos()
    {
        return $this->descuentos;
    }

    /**
     * @param Charge[] $descuentos
     * @return SaleDetail
     */
    public function setDescuentos($descuentos)
    {
        $this->descuentos = $descuentos;
        return $this;
    }

    /**
     * @return DetailAttribute[]
     */
    public function getAtributos()
    {
        return $this->atributos;
    }

    /**
     * @param DetailAttribute[] $atributos
     * @return SaleDetail
     */
    public function setAtributos($atributos)
    {
        $this->atributos = $atributos;
        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05.
 */

declare(strict_types=1);

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
    private $icbper;
    /**
     * @var float
     */
    private $factorIcbper = 0.30;
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
     * Valor referencial unitario por ítem en
     * operaciones no onerosas (gratuita).
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
    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    /**
     * @param string $unidad
     *
     * @return SaleDetail
     */
    public function setUnidad(?string $unidad): SaleDetail
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
     * @return SaleDetail
     */
    public function setCantidad(?float $cantidad): SaleDetail
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodProducto(): ?string
    {
        return $this->codProducto;
    }

    /**
     * @param string $codProducto
     *
     * @return SaleDetail
     */
    public function setCodProducto(?string $codProducto): SaleDetail
    {
        $this->codProducto = $codProducto;

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
     * @return SaleDetail
     */
    public function setCodProdSunat(?string $codProdSunat): SaleDetail
    {
        $this->codProdSunat = $codProdSunat;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodProdGS1(): ?string
    {
        return $this->codProdGS1;
    }

    /**
     * @param string $codProdGS1
     *
     * @return SaleDetail
     */
    public function setCodProdGS1(?string $codProdGS1): SaleDetail
    {
        $this->codProdGS1 = $codProdGS1;

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
     * @return SaleDetail
     */
    public function setDescripcion(?string $descripcion): SaleDetail
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorUnitario(): ?float
    {
        return $this->mtoValorUnitario;
    }

    /**
     * @param float $mtoValorUnitario
     *
     * @return SaleDetail
     */
    public function setMtoValorUnitario(?float $mtoValorUnitario): SaleDetail
    {
        $this->mtoValorUnitario = $mtoValorUnitario;

        return $this;
    }

    /**
     * @return Charge[]
     */
    public function getCargos(): ?array
    {
        return $this->cargos;
    }

    /**
     * @param Charge[] $cargos
     *
     * @return SaleDetail
     */
    public function setCargos(?array $cargos): SaleDetail
    {
        $this->cargos = $cargos;

        return $this;
    }

    /**
     * @return Charge[]
     */
    public function getDescuentos(): ?array
    {
        return $this->descuentos;
    }

    /**
     * @param Charge[] $descuentos
     *
     * @return SaleDetail
     */
    public function setDescuentos(?array $descuentos): SaleDetail
    {
        $this->descuentos = $descuentos;

        return $this;
    }

    /**
     * @return float
     */
    public function getDescuento(): ?float
    {
        return $this->descuento;
    }

    /**
     * @param float $descuento
     *
     * @return SaleDetail
     */
    public function setDescuento(?float $descuento): SaleDetail
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIgv(): ?float
    {
        return $this->mtoBaseIgv;
    }

    /**
     * @param float $mtoBaseIgv
     *
     * @return SaleDetail
     */
    public function setMtoBaseIgv(?float $mtoBaseIgv): SaleDetail
    {
        $this->mtoBaseIgv = $mtoBaseIgv;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeIgv(): ?float
    {
        return $this->porcentajeIgv;
    }

    /**
     * @param float $porcentajeIgv
     *
     * @return SaleDetail
     */
    public function setPorcentajeIgv(?float $porcentajeIgv): SaleDetail
    {
        $this->porcentajeIgv = $porcentajeIgv;

        return $this;
    }

    /**
     * @return float
     */
    public function getIgv(): ?float
    {
        return $this->igv;
    }

    /**
     * @param float $igv
     *
     * @return SaleDetail
     */
    public function setIgv(?float $igv): SaleDetail
    {
        $this->igv = $igv;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipAfeIgv(): ?string
    {
        return $this->tipAfeIgv;
    }

    /**
     * @param string $tipAfeIgv
     *
     * @return SaleDetail
     */
    public function setTipAfeIgv(?string $tipAfeIgv): SaleDetail
    {
        $this->tipAfeIgv = $tipAfeIgv;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIsc(): ?float
    {
        return $this->mtoBaseIsc;
    }

    /**
     * @param float $mtoBaseIsc
     *
     * @return SaleDetail
     */
    public function setMtoBaseIsc(?float $mtoBaseIsc): SaleDetail
    {
        $this->mtoBaseIsc = $mtoBaseIsc;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeIsc(): ?float
    {
        return $this->porcentajeIsc;
    }

    /**
     * @param float $porcentajeIsc
     *
     * @return SaleDetail
     */
    public function setPorcentajeIsc(?float $porcentajeIsc): SaleDetail
    {
        $this->porcentajeIsc = $porcentajeIsc;

        return $this;
    }

    /**
     * @return float
     */
    public function getIsc(): ?float
    {
        return $this->isc;
    }

    /**
     * @param float $isc
     *
     * @return SaleDetail
     */
    public function setIsc(?float $isc): SaleDetail
    {
        $this->isc = $isc;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipSisIsc(): ?string
    {
        return $this->tipSisIsc;
    }

    /**
     * @param string $tipSisIsc
     *
     * @return SaleDetail
     */
    public function setTipSisIsc(?string $tipSisIsc): SaleDetail
    {
        $this->tipSisIsc = $tipSisIsc;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseOth(): ?float
    {
        return $this->mtoBaseOth;
    }

    /**
     * @param float $mtoBaseOth
     *
     * @return SaleDetail
     */
    public function setMtoBaseOth(?float $mtoBaseOth): SaleDetail
    {
        $this->mtoBaseOth = $mtoBaseOth;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeOth(): ?float
    {
        return $this->porcentajeOth;
    }

    /**
     * @param float $porcentajeOth
     *
     * @return SaleDetail
     */
    public function setPorcentajeOth(?float $porcentajeOth): SaleDetail
    {
        $this->porcentajeOth = $porcentajeOth;

        return $this;
    }

    /**
     * @return float
     */
    public function getOtroTributo(): ?float
    {
        return $this->otroTributo;
    }

    /**
     * @param float $otroTributo
     *
     * @return SaleDetail
     */
    public function setOtroTributo(?float $otroTributo): SaleDetail
    {
        $this->otroTributo = $otroTributo;

        return $this;
    }

    /**
     * @return float
     */
    public function getIcbper(): ?float
    {
        return $this->icbper;
    }

    /**
     * @param float $icbper
     *
     * @return SaleDetail
     */
    public function setIcbper(?float $icbper): SaleDetail
    {
        $this->icbper = $icbper;

        return $this;
    }

    /**
     * @return float
     */
    public function getFactorIcbper(): ?float
    {
        return $this->factorIcbper;
    }

    /**
     * @param float $factorIcbper
     *
     * @return SaleDetail
     */
    public function setFactorIcbper(?float $factorIcbper): SaleDetail
    {
        $this->factorIcbper = $factorIcbper;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalImpuestos(): ?float
    {
        return $this->totalImpuestos;
    }

    /**
     * @param float $totalImpuestos
     *
     * @return SaleDetail
     */
    public function setTotalImpuestos(?float $totalImpuestos): SaleDetail
    {
        $this->totalImpuestos = $totalImpuestos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoPrecioUnitario(): ?float
    {
        return $this->mtoPrecioUnitario;
    }

    /**
     * @param float $mtoPrecioUnitario
     *
     * @return SaleDetail
     */
    public function setMtoPrecioUnitario(?float $mtoPrecioUnitario): SaleDetail
    {
        $this->mtoPrecioUnitario = $mtoPrecioUnitario;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorVenta(): ?float
    {
        return $this->mtoValorVenta;
    }

    /**
     * @param float $mtoValorVenta
     *
     * @return SaleDetail
     */
    public function setMtoValorVenta(?float $mtoValorVenta): SaleDetail
    {
        $this->mtoValorVenta = $mtoValorVenta;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorGratuito(): ?float
    {
        return $this->mtoValorGratuito;
    }

    /**
     * @param float $mtoValorGratuito
     *
     * @return SaleDetail
     */
    public function setMtoValorGratuito(?float $mtoValorGratuito): SaleDetail
    {
        $this->mtoValorGratuito = $mtoValorGratuito;

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
     *
     * @return SaleDetail
     */
    public function setAtributos(?array $atributos): SaleDetail
    {
        $this->atributos = $atributos;

        return $this;
    }
}

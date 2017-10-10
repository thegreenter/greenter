<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05
 */

namespace Greenter\Model\Sale;

/**
 * Class SaleDetail
 * @package Greenter\Model\Sale
 */
class SaleDetail
{
    /**
     * Codigo unidad de Medida.
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @var string
     */
    private $codUnidadMedida;
    /**
     * Cantidad de unidades por ítem.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $ctdUnidadItem;

    /**
     * @var string
     */
    private $codProducto;

    /**
     * Descripcion del Producto.
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max="250",
     *     maxMessage="El valor demasiado largo, longitud maxima es {{ limit }}"
     * )
     * @var string
     */
    private $desItem;

    /**
     * Monto del valor unitario (PrecioUnitario SIN IGV).
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoValorUnitario;

    /**
     * @var float
     */
    private $mtoDsctoItem;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoIgvItem;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $tipAfeIgv;

    /**
     * @var float
     */
    private $mtoIscItem;

    /**
     * @var string
     */
    private $tipSisIsc;

    /**
     * Precio de venta unitario por item.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoPrecioUnitario;

    /**
     * Valor de venta por ítem. (Total).
     *
     * @Assert\NotBlank()
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
    public function getCodUnidadMedida()
    {
        return $this->codUnidadMedida;
    }

    /**
     * @param string $codUnidadMedida
     * @return SaleDetail
     */
    public function setCodUnidadMedida($codUnidadMedida)
    {
        $this->codUnidadMedida = $codUnidadMedida;
        return $this;
    }

    /**
     * @return float
     */
    public function getCtdUnidadItem()
    {
        return $this->ctdUnidadItem;
    }

    /**
     * @param float $ctdUnidadItem
     * @return SaleDetail
     */
    public function setCtdUnidadItem($ctdUnidadItem)
    {
        $this->ctdUnidadItem = $ctdUnidadItem;
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
    public function getDesItem()
    {
        return $this->desItem;
    }

    /**
     * @param string $desItem
     * @return SaleDetail
     */
    public function setDesItem($desItem)
    {
        $this->desItem = $desItem;
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
    public function getMtoDsctoItem()
    {
        return $this->mtoDsctoItem;
    }

    /**
     * @param float $mtoDsctoItem
     * @return SaleDetail
     */
    public function setMtoDsctoItem($mtoDsctoItem)
    {
        $this->mtoDsctoItem = $mtoDsctoItem;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIgvItem()
    {
        return $this->mtoIgvItem;
    }

    /**
     * @param float $mtoIgvItem
     * @return SaleDetail
     */
    public function setMtoIgvItem($mtoIgvItem)
    {
        $this->mtoIgvItem = $mtoIgvItem;
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
    public function getMtoIscItem()
    {
        return $this->mtoIscItem;
    }

    /**
     * @param float $mtoIscItem
     * @return SaleDetail
     */
    public function setMtoIscItem($mtoIscItem)
    {
        $this->mtoIscItem = $mtoIscItem;
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
     * @return SaleDetail
     */
    public function setMtoValorGratuito($mtoValorGratuito)
    {
        $this->mtoValorGratuito = $mtoValorGratuito;
        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05
 */

namespace Greenter\Xml\Model\Sale;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SaleDetail
 * @package Greenter\Xml\Model\Sale
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
     * @var double
     */
    private $ctdUnidadItem;

    /**
     * @var string
     */
    private $codProducto;

    /**
     * @var string
     */
    private $codProductoSUNAT;

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
     * @var double
     */
    private $mtoValorUnitario;

    /**
     * @var double
     */
    private $mtoDsctoItem;

    /**
     * @Assert\NotBlank()
     * @var double
     */
    private $mtoIgvItem;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $tipAfeIgv;

    /**
     * @var double
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
     * @var double
     */
    private $mtoPrecioVentaItem;

    /**
     * Valor de venta por ítem. (Total).
     *
     * @Assert\NotBlank()
     * @var double
     */
    private $mtoValorVentaItem;

    /**
     * Valor referencial unitario por ítem en operaciones no onerosas (gratuita).
     *
     * @var double
     */
    private $mtoValorUnitarioGratuito;

    /**
     * @return mixed
     */
    public function getCodUnidadMedida()
    {
        return $this->codUnidadMedida;
    }

    /**
     * @param mixed $codUnidadMedida
     * @return SaleDetail
     */
    public function setCodUnidadMedida($codUnidadMedida)
    {
        $this->codUnidadMedida = $codUnidadMedida;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCtdUnidadItem()
    {
        return $this->ctdUnidadItem;
    }

    /**
     * @param mixed $ctdUnidadItem
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
    public function getCodProductoSUNAT()
    {
        return $this->codProductoSUNAT;
    }

    /**
     * @param string $codProductoSUNAT
     * @return SaleDetail
     */
    public function setCodProductoSUNAT($codProductoSUNAT)
    {
        $this->codProductoSUNAT = $codProductoSUNAT;
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
    public function getMtoPrecioVentaItem()
    {
        return $this->mtoPrecioVentaItem;
    }

    /**
     * @param float $mtoPrecioVentaItem
     * @return SaleDetail
     */
    public function setMtoPrecioVentaItem($mtoPrecioVentaItem)
    {
        $this->mtoPrecioVentaItem = $mtoPrecioVentaItem;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorVentaItem()
    {
        return $this->mtoValorVentaItem;
    }

    /**
     * @param float $mtoValorVentaItem
     * @return SaleDetail
     */
    public function setMtoValorVentaItem($mtoValorVentaItem)
    {
        $this->mtoValorVentaItem = $mtoValorVentaItem;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoValorUnitarioGratuito()
    {
        return $this->mtoValorUnitarioGratuito;
    }

    /**
     * @param float $mtoValorUnitarioGratuito
     * @return SaleDetail
     */
    public function setMtoValorUnitarioGratuito($mtoValorUnitarioGratuito)
    {
        $this->mtoValorUnitarioGratuito = $mtoValorUnitarioGratuito;
        return $this;
    }
}
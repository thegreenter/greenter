<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05.
 */

namespace Greenter\Model\Sale;
use Greenter\Model\Client\Client;

/**
 * Invoice 2.1.
 *
 * Class Invoice.
 */
class Invoice extends BaseSale
{
    /**
     * Tipo operacion (Catálogo 51).
     *
     * @var string
     */
    private $tipoOperacion;

    /**
     * @var \DateTime
     */
    private $fecVencimiento;

    /**
     * @var float
     */
    private $mtoOperGratuitas;

    /**
     * @var float
     */
    private $sumDsctoGlobal;

    /**
     * @var float
     */
    private $mtoDescuentos;

    /**
     * @var float
     */
    private $totalAnticipos;

    /**
     * @var SalePerception
     */
    private $perception;

    /**
     * Orden de Compra relacionado.
     *
     * @var string
     */
    private $compra;

    /**
     * @var Prepayment[]
     */
    private $anticipos;

    /**
     * @var Detraction
     */
    private $detraccion;

    /**
     * Utilizado cuando se trata de una Factura Guia.
     *
     * @var EmbededDespatch
     */
    private $guiaEmbebida;

    /**
     * @var Client
     */
    private $seller;

    /**
     * @return string
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * @param string $tipoOperacion
     *
     * @return Invoice
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecVencimiento()
    {
        return $this->fecVencimiento;
    }

    /**
     * @param \DateTime $fecVencimiento
     *
     * @return Invoice
     */
    public function setFecVencimiento($fecVencimiento)
    {
        $this->fecVencimiento = $fecVencimiento;

        return $this;
    }

    /**
     * @return float
     */
    public function getSumDsctoGlobal()
    {
        return $this->sumDsctoGlobal;
    }

    /**
     * @param float $sumDsctoGlobal
     *
     * @return Invoice
     */
    public function setSumDsctoGlobal($sumDsctoGlobal)
    {
        $this->sumDsctoGlobal = $sumDsctoGlobal;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoDescuentos()
    {
        return $this->mtoDescuentos;
    }

    /**
     * @param float $mtoDescuentos
     *
     * @return Invoice
     */
    public function setMtoDescuentos($mtoDescuentos)
    {
        $this->mtoDescuentos = $mtoDescuentos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGratuitas()
    {
        return $this->mtoOperGratuitas;
    }

    /**
     * @param float $mtoOperGratuitas
     *
     * @return Invoice
     */
    public function setMtoOperGratuitas($mtoOperGratuitas)
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalAnticipos()
    {
        return $this->totalAnticipos;
    }

    /**
     * @param mixed $totalAnticipos
     *
     * @return Invoice
     */
    public function setTotalAnticipos($totalAnticipos)
    {
        $this->totalAnticipos = $totalAnticipos;

        return $this;
    }

    /**
     * @return SalePerception
     */
    public function getPerception()
    {
        return $this->perception;
    }

    /**
     * @param SalePerception $perception
     *
     * @return Invoice
     */
    public function setPerception($perception)
    {
        $this->perception = $perception;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * @param string $compra
     *
     * @return Invoice
     */
    public function setCompra($compra)
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * @return Prepayment[]
     */
    public function getAnticipos()
    {
        return $this->anticipos;
    }

    /**
     * @param Prepayment[] $anticipos
     *
     * @return Invoice
     */
    public function setAnticipos($anticipos)
    {
        $this->anticipos = $anticipos;

        return $this;
    }

    /**
     * @return Detraction
     */
    public function getDetraccion()
    {
        return $this->detraccion;
    }

    /**
     * @param Detraction $detraccion
     *
     * @return Invoice
     */
    public function setDetraccion($detraccion)
    {
        $this->detraccion = $detraccion;

        return $this;
    }

    /**
     * @return EmbededDespatch
     */
    public function getGuiaEmbebida()
    {
        return $this->guiaEmbebida;
    }

    /**
     * @param EmbededDespatch $guiaEmbebida
     *
     * @return Invoice
     */
    public function setGuiaEmbebida($guiaEmbebida)
    {
        $this->guiaEmbebida = $guiaEmbebida;

        return $this;
    }

    /**
     * @return Client
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param Client $seller
     * @return Invoice
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;
        return $this;
    }
}

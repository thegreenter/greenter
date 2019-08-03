<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05.
 */

namespace Greenter\Model\Sale;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;

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
     * @var Charge[]
     */
    private $descuentos;

    /**
     * @var Charge[]
     */
    private $cargos;

    /**
     * @var float
     */
    private $mtoCargos;

    /**
     * @var float
     */
    private $totalAnticipos;

    /**
     * @var SalePerception
     */
    private $perception;

    /**
     * Utilizado cuando se trata de una Factura Guia.
     *
     * @var EmbededDespatch
     */
    private $guiaEmbebida;

    /**
     * @var Prepayment[]
     */
    private $anticipos;

    /**
     * @var Detraction
     */
    private $detraccion;

    /**
     * @var Client
     */
    private $seller;

    /**
     * @var float
     */
    private $valorVenta;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var Address
     */
    private $direccionEntrega;

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
     * @deprecated UBL 2.1
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
     * @return Client
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param Client $seller
     *
     * @return Invoice
     */
    public function setSeller($seller)
    {
        $this->seller = $seller;

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
     *
     * @return Invoice
     */
    public function setDescuentos($descuentos)
    {
        $this->descuentos = $descuentos;

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
     *
     * @return Invoice
     */
    public function setCargos($cargos)
    {
        $this->cargos = $cargos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoCargos()
    {
        return $this->mtoCargos;
    }

    /**
     * @param float $mtoCargos
     *
     * @return Invoice
     */
    public function setMtoCargos($mtoCargos)
    {
        $this->mtoCargos = $mtoCargos;

        return $this;
    }

    /**
     * @return float
     */
    public function getValorVenta()
    {
        return $this->valorVenta;
    }

    /**
     * @param float $valorVenta
     *
     * @return Invoice
     */
    public function setValorVenta($valorVenta)
    {
        $this->valorVenta = $valorVenta;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     *
     * @return Invoice
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return Address
     */
    public function getDireccionEntrega()
    {
        return $this->direccionEntrega;
    }

    /**
     * Direccion Entrega utilizada en ventas itinerantes.
     *
     * @param Address $direccionEntrega
     *
     * @return Invoice
     */
    public function setDireccionEntrega($direccionEntrega)
    {
        $this->direccionEntrega = $direccionEntrega;

        return $this;
    }
}

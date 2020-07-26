<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

use DateTimeInterface;
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
     * @var DateTimeInterface
     */
    private $fecVencimiento;

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
    private $sumOtrosDescuentos;

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
     * @var float
     */
    private $subTotal;

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
    public function getTipoOperacion(): ?string
    {
        return $this->tipoOperacion;
    }

    /**
     * @param string $tipoOperacion
     *
     * @return Invoice
     */
    public function setTipoOperacion(?string $tipoOperacion): Invoice
    {
        $this->tipoOperacion = $tipoOperacion;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFecVencimiento(): ?DateTimeInterface
    {
        return $this->fecVencimiento;
    }

    /**
     * @param DateTimeInterface $fecVencimiento
     *
     * @return Invoice
     */
    public function setFecVencimiento(?DateTimeInterface $fecVencimiento): Invoice
    {
        $this->fecVencimiento = $fecVencimiento;

        return $this;
    }

    /**
     * @return float
     */
    public function getSumDsctoGlobal(): ?float
    {
        return $this->sumDsctoGlobal;
    }

    /**
     * @param float $sumDsctoGlobal
     *
     * @return Invoice
     */
    public function setSumDsctoGlobal(?float $sumDsctoGlobal): Invoice
    {
        $this->sumDsctoGlobal = $sumDsctoGlobal;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoDescuentos(): ?float
    {
        return $this->mtoDescuentos;
    }

    /**
     * @param float $mtoDescuentos
     *
     * @return Invoice
     */
    public function setMtoDescuentos(?float $mtoDescuentos): Invoice
    {
        $this->mtoDescuentos = $mtoDescuentos;

        return $this;
    }

    /**
     * @return float
     */
    public function getSumOtrosDescuentos(): ?float
    {
        return $this->sumOtrosDescuentos;
    }

    /**
     * @param float $sumOtrosDescuentos
     *
     * @return Invoice
     */
    public function setSumOtrosDescuentos(?float $sumOtrosDescuentos): Invoice
    {
        $this->sumOtrosDescuentos = $sumOtrosDescuentos;

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
     * @return Invoice
     */
    public function setDescuentos(?array $descuentos): Invoice
    {
        $this->descuentos = $descuentos;

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
     * @return Invoice
     */
    public function setCargos(?array $cargos): Invoice
    {
        $this->cargos = $cargos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoCargos(): ?float
    {
        return $this->mtoCargos;
    }

    /**
     * @param float $mtoCargos
     *
     * @return Invoice
     */
    public function setMtoCargos(?float $mtoCargos): Invoice
    {
        $this->mtoCargos = $mtoCargos;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAnticipos(): ?float
    {
        return $this->totalAnticipos;
    }

    /**
     * @param float $totalAnticipos
     *
     * @return Invoice
     */
    public function setTotalAnticipos(?float $totalAnticipos): Invoice
    {
        $this->totalAnticipos = $totalAnticipos;

        return $this;
    }

    /**
     * @return SalePerception
     */
    public function getPerception(): ?SalePerception
    {
        return $this->perception;
    }

    /**
     * @param SalePerception $perception
     *
     * @return Invoice
     */
    public function setPerception(?SalePerception $perception): Invoice
    {
        $this->perception = $perception;

        return $this;
    }

    /**
     * @return EmbededDespatch
     */
    public function getGuiaEmbebida(): ?EmbededDespatch
    {
        return $this->guiaEmbebida;
    }

    /**
     * @param EmbededDespatch $guiaEmbebida
     *
     * @return Invoice
     */
    public function setGuiaEmbebida(?EmbededDespatch $guiaEmbebida): Invoice
    {
        $this->guiaEmbebida = $guiaEmbebida;

        return $this;
    }

    /**
     * @return Prepayment[]
     */
    public function getAnticipos(): ?array
    {
        return $this->anticipos;
    }

    /**
     * @param Prepayment[] $anticipos
     *
     * @return Invoice
     */
    public function setAnticipos(?array $anticipos): Invoice
    {
        $this->anticipos = $anticipos;

        return $this;
    }

    /**
     * @return Detraction
     */
    public function getDetraccion(): ?Detraction
    {
        return $this->detraccion;
    }

    /**
     * @param Detraction $detraccion
     *
     * @return Invoice
     */
    public function setDetraccion(?Detraction $detraccion): Invoice
    {
        $this->detraccion = $detraccion;

        return $this;
    }

    /**
     * @return Client
     */
    public function getSeller(): ?Client
    {
        return $this->seller;
    }

    /**
     * @param Client $seller
     *
     * @return Invoice
     */
    public function setSeller(?Client $seller): Invoice
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * @return float
     */
    public function getValorVenta(): ?float
    {
        return $this->valorVenta;
    }

    /**
     * @param float $valorVenta
     *
     * @return Invoice
     */
    public function setValorVenta(?float $valorVenta): Invoice
    {
        $this->valorVenta = $valorVenta;

        return $this;
    }

    /**
     * @return float
     */
    public function getSubTotal(): ?float
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     *
     * @return Invoice
     */
    public function setSubTotal(?float $subTotal): Invoice
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     *
     * @return Invoice
     */
    public function setObservacion(?string $observacion): Invoice
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return Address
     */
    public function getDireccionEntrega(): ?Address
    {
        return $this->direccionEntrega;
    }

    /**
     * @param Address $direccionEntrega
     *
     * @return Invoice
     */
    public function setDireccionEntrega(?Address $direccionEntrega): Invoice
    {
        $this->direccionEntrega = $direccionEntrega;

        return $this;
    }
}

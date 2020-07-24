<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:28 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Perception;

use DateTimeInterface;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;

/**
 * Class PerceptionDetail.
 */
class PerceptionDetail
{
    /**
     * Tipo de documento Relacionado.
     *
     * @var string
     */
    private $tipoDoc;

    /**
     * Numero del documento relacionado (Serie-Correlativo).
     *
     * @var string
     */
    private $numDoc;

    /**
     * Fecha de Emision del documento relacionado.
     *
     * @var DateTimeInterface
     */
    private $fechaEmision;

    /**
     * Importe total documento Relacionado.
     *
     * @var float
     */
    private $impTotal;

    /**
     * Moneda del docoumento relacionado.
     *
     * @var string
     */
    private $moneda;

    /**
     * Datos del Cobro.
     *
     * @var Payment[]
     */
    private $cobros;

    /**
     * Fecha de Retención.
     *
     * @var DateTimeInterface
     */
    private $fechaPercepcion;

    /**
     * Importe Percibido.
     *
     * @var float
     */
    private $impPercibido;

    /**
     * Importe total a cobrar (neto).
     *
     * @var float
     */
    private $impCobrar;

    /**
     * @var Exchange
     */
    private $tipoCambio;

    /**
     * @return string
     */
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return PerceptionDetail
     */
    public function setTipoDoc(?string $tipoDoc): PerceptionDetail
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc(): ?string
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     *
     * @return PerceptionDetail
     */
    public function setNumDoc(?string $numDoc): PerceptionDetail
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFechaEmision(): ?DateTimeInterface
    {
        return $this->fechaEmision;
    }

    /**
     * @param DateTimeInterface $fechaEmision
     *
     * @return PerceptionDetail
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): PerceptionDetail
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpTotal(): ?float
    {
        return $this->impTotal;
    }

    /**
     * @param float $impTotal
     *
     * @return PerceptionDetail
     */
    public function setImpTotal(?float $impTotal): PerceptionDetail
    {
        $this->impTotal = $impTotal;

        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     *
     * @return PerceptionDetail
     */
    public function setMoneda(?string $moneda): PerceptionDetail
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getCobros(): ?array
    {
        return $this->cobros;
    }

    /**
     * @param Payment[] $cobros
     *
     * @return PerceptionDetail
     */
    public function setCobros(?array $cobros): PerceptionDetail
    {
        $this->cobros = $cobros;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFechaPercepcion(): ?DateTimeInterface
    {
        return $this->fechaPercepcion;
    }

    /**
     * @param DateTimeInterface $fechaPercepcion
     *
     * @return PerceptionDetail
     */
    public function setFechaPercepcion(?DateTimeInterface $fechaPercepcion): PerceptionDetail
    {
        $this->fechaPercepcion = $fechaPercepcion;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPercibido(): ?float
    {
        return $this->impPercibido;
    }

    /**
     * @param float $impPercibido
     *
     * @return PerceptionDetail
     */
    public function setImpPercibido(?float $impPercibido): PerceptionDetail
    {
        $this->impPercibido = $impPercibido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpCobrar(): ?float
    {
        return $this->impCobrar;
    }

    /**
     * @param float $impCobrar
     *
     * @return PerceptionDetail
     */
    public function setImpCobrar(?float $impCobrar): PerceptionDetail
    {
        $this->impCobrar = $impCobrar;

        return $this;
    }

    /**
     * @return Exchange
     */
    public function getTipoCambio(): ?Exchange
    {
        return $this->tipoCambio;
    }

    /**
     * @param Exchange $tipoCambio
     *
     * @return PerceptionDetail
     */
    public function setTipoCambio(?Exchange $tipoCambio): PerceptionDetail
    {
        $this->tipoCambio = $tipoCambio;

        return $this;
    }
}

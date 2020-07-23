<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:47 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Retention;

use DateTimeInterface;

/**
 * Class RetentionDetail.
 */
class RetentionDetail
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
     * Datos del Pago.
     *
     * @var Payment[]
     */
    private $pagos;

    /**
     * Fecha de Retención.
     *
     * @var DateTimeInterface
     */
    private $fechaRetencion;

    /**
     * Importe retenido.
     *
     * @var float
     */
    private $impRetenido;

    /**
     * Importe total a pagar (neto).
     *
     * @var float
     */
    private $impPagar;

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
     * @return RetentionDetail
     */
    public function setTipoDoc(?string $tipoDoc): RetentionDetail
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
     * @return RetentionDetail
     */
    public function setNumDoc(?string $numDoc): RetentionDetail
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
     * @return RetentionDetail
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): RetentionDetail
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
     * @return RetentionDetail
     */
    public function setImpTotal(?float $impTotal): RetentionDetail
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
     * @return RetentionDetail
     */
    public function setMoneda(?string $moneda): RetentionDetail
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getPagos(): ?array
    {
        return $this->pagos;
    }

    /**
     * @param Payment[] $pagos
     *
     * @return RetentionDetail
     */
    public function setPagos(?array $pagos): RetentionDetail
    {
        $this->pagos = $pagos;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFechaRetencion(): ?DateTimeInterface
    {
        return $this->fechaRetencion;
    }

    /**
     * @param DateTimeInterface $fechaRetencion
     *
     * @return RetentionDetail
     */
    public function setFechaRetencion(?DateTimeInterface $fechaRetencion): RetentionDetail
    {
        $this->fechaRetencion = $fechaRetencion;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpRetenido(): ?float
    {
        return $this->impRetenido;
    }

    /**
     * @param float $impRetenido
     *
     * @return RetentionDetail
     */
    public function setImpRetenido(?float $impRetenido): RetentionDetail
    {
        $this->impRetenido = $impRetenido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPagar(): ?float
    {
        return $this->impPagar;
    }

    /**
     * @param float $impPagar
     *
     * @return RetentionDetail
     */
    public function setImpPagar(?float $impPagar): RetentionDetail
    {
        $this->impPagar = $impPagar;

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
     * @return RetentionDetail
     */
    public function setTipoCambio(?Exchange $tipoCambio): RetentionDetail
    {
        $this->tipoCambio = $tipoCambio;

        return $this;
    }
}

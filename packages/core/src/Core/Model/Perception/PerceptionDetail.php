<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:28 AM.
 */

namespace Greenter\Model\Perception;

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
     * @var \DateTime
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
     * @var \DateTime
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
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return PerceptionDetail
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc()
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     *
     * @return PerceptionDetail
     */
    public function setNumDoc($numDoc)
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * @param \DateTime $fechaEmision
     *
     * @return PerceptionDetail
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpTotal()
    {
        return $this->impTotal;
    }

    /**
     * @param float $impTotal
     *
     * @return PerceptionDetail
     */
    public function setImpTotal($impTotal)
    {
        $this->impTotal = $impTotal;

        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     *
     * @return PerceptionDetail
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getCobros()
    {
        return $this->cobros;
    }

    /**
     * @param Payment[] $cobros
     *
     * @return PerceptionDetail
     */
    public function setCobros($cobros)
    {
        $this->cobros = $cobros;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaPercepcion()
    {
        return $this->fechaPercepcion;
    }

    /**
     * @param \DateTime $fechaPercepcion
     *
     * @return PerceptionDetail
     */
    public function setFechaPercepcion($fechaPercepcion)
    {
        $this->fechaPercepcion = $fechaPercepcion;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPercibido()
    {
        return $this->impPercibido;
    }

    /**
     * @param float $impPercibido
     *
     * @return PerceptionDetail
     */
    public function setImpPercibido($impPercibido)
    {
        $this->impPercibido = $impPercibido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpCobrar()
    {
        return $this->impCobrar;
    }

    /**
     * @param float $impCobrar
     *
     * @return PerceptionDetail
     */
    public function setImpCobrar($impCobrar)
    {
        $this->impCobrar = $impCobrar;

        return $this;
    }

    /**
     * @return Exchange
     */
    public function getTipoCambio()
    {
        return $this->tipoCambio;
    }

    /**
     * @param Exchange $tipoCambio
     *
     * @return PerceptionDetail
     */
    public function setTipoCambio($tipoCambio)
    {
        $this->tipoCambio = $tipoCambio;

        return $this;
    }
}

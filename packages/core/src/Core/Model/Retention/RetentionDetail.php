<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:47 AM.
 */

namespace Greenter\Model\Retention;

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
     * Datos del Pago.
     *
     * @var Payment[]
     */
    private $pagos;

    /**
     * Fecha de Retención.
     *
     * @var \DateTime
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
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return RetentionDetail
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
     * @return RetentionDetail
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
     * @return RetentionDetail
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
     * @return RetentionDetail
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
     * @return RetentionDetail
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Payment[]
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * @param Payment[] $pagos
     *
     * @return RetentionDetail
     */
    public function setPagos($pagos)
    {
        $this->pagos = $pagos;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFechaRetencion()
    {
        return $this->fechaRetencion;
    }

    /**
     * @param \DateTime $fechaRetencion
     *
     * @return RetentionDetail
     */
    public function setFechaRetencion($fechaRetencion)
    {
        $this->fechaRetencion = $fechaRetencion;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpRetenido()
    {
        return $this->impRetenido;
    }

    /**
     * @param float $impRetenido
     *
     * @return RetentionDetail
     */
    public function setImpRetenido($impRetenido)
    {
        $this->impRetenido = $impRetenido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPagar()
    {
        return $this->impPagar;
    }

    /**
     * @param float $impPagar
     *
     * @return RetentionDetail
     */
    public function setImpPagar($impPagar)
    {
        $this->impPagar = $impPagar;

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
     * @return RetentionDetail
     */
    public function setTipoCambio($tipoCambio)
    {
        $this->tipoCambio = $tipoCambio;

        return $this;
    }
}

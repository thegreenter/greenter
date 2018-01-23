<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/10/2017
 * Time: 05:38 PM.
 */

namespace Greenter\Model\Sale;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Recibo por Honorarios.
 *
 * Class Receipt
 */
class Receipt implements DocumentInterface
{
    /**
     * Persona natural que emite el recibo.
     *
     * @var Company
     */
    private $person;

    /**
     * Receptor del rr.hh.
     *
     * @var Client
     */
    private $receptor;

    /**
     * Serie del Documento (ejem: E001).
     *
     * @var string
     */
    private $serie;

    /**
     * Correlativo del Documento.
     *
     * @var string
     */
    private $correlativo;

    /**
     * Fecha de emisión.
     *
     * @var \DateTime
     */
    private $fechaEmision;

    /**
     * Concepto del recibo.
     *
     * @var string
     */
    private $concepto;

    /**
     * Monto total en letras.
     *
     * @var string
     */
    private $montoLetras;

    /**
     * Total por honorarios.
     *
     * @var float
     */
    private $subTotal;

    /**
     * Monto retenido.
     *
     * @var float
     */
    private $retencion;

    /**
     * Porcentaje aplicado.
     *
     * @var float
     */
    private $porcentaje;

    /**
     * Total Neto Recibido.
     *
     * @var float
     */
    private $total;

    /**
     * @return Company
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Company $person
     *
     * @return Receipt
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @return Client
     */
    public function getReceptor()
    {
        return $this->receptor;
    }

    /**
     * @param Client $receptor
     *
     * @return Receipt
     */
    public function setReceptor($receptor)
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     *
     * @return Receipt
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return Receipt
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

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
     * @return Receipt
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * @param string $concepto
     *
     * @return Receipt
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * @return string
     */
    public function getMontoLetras()
    {
        return $this->montoLetras;
    }

    /**
     * @param string $montoLetras
     *
     * @return Receipt
     */
    public function setMontoLetras($montoLetras)
    {
        $this->montoLetras = $montoLetras;

        return $this;
    }

    /**
     * @return float
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     *
     * @return Receipt
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getRetencion()
    {
        return $this->retencion;
    }

    /**
     * @param float $retencion
     *
     * @return Receipt
     */
    public function setRetencion($retencion)
    {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * @param float $porcentaje
     *
     * @return Receipt
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     *
     * @return Receipt
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get Name for Document.
     *
     * @return string
     */
    public function getName()
    {
        return 'RHE'.$this->person->getRuc().$this->getCorrelativo();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/10/2017
 * Time: 05:38 PM.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

use DateTimeInterface;
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
     * @var DateTimeInterface
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
    public function getPerson(): ?Company
    {
        return $this->person;
    }

    /**
     * @param Company $person
     *
     * @return Receipt
     */
    public function setPerson(?Company $person): Receipt
    {
        $this->person = $person;

        return $this;
    }

    /**
     * @return Client
     */
    public function getReceptor(): ?Client
    {
        return $this->receptor;
    }

    /**
     * @param Client $receptor
     *
     * @return Receipt
     */
    public function setReceptor(?Client $receptor): Receipt
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     *
     * @return Receipt
     */
    public function setSerie(?string $serie): Receipt
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorrelativo(): ?string
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return Receipt
     */
    public function setCorrelativo(?string $correlativo): Receipt
    {
        $this->correlativo = $correlativo;

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
     * @return Receipt
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): Receipt
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return string
     */
    public function getConcepto(): ?string
    {
        return $this->concepto;
    }

    /**
     * @param string $concepto
     *
     * @return Receipt
     */
    public function setConcepto(?string $concepto): Receipt
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * @return string
     */
    public function getMontoLetras(): ?string
    {
        return $this->montoLetras;
    }

    /**
     * @param string $montoLetras
     *
     * @return Receipt
     */
    public function setMontoLetras(?string $montoLetras): Receipt
    {
        $this->montoLetras = $montoLetras;

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
     * @return Receipt
     */
    public function setSubTotal(?float $subTotal): Receipt
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * @return float
     */
    public function getRetencion(): ?float
    {
        return $this->retencion;
    }

    /**
     * @param float $retencion
     *
     * @return Receipt
     */
    public function setRetencion(?float $retencion): Receipt
    {
        $this->retencion = $retencion;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentaje(): ?float
    {
        return $this->porcentaje;
    }

    /**
     * @param float $porcentaje
     *
     * @return Receipt
     */
    public function setPorcentaje(?float $porcentaje): Receipt
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float $total
     *
     * @return Receipt
     */
    public function setTotal(?float $total): Receipt
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get Name for Document.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'RHE'.$this->person->getRuc().$this->getCorrelativo();
    }
}

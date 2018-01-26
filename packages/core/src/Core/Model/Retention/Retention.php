<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:37 AM.
 */

namespace Greenter\Model\Retention;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Retention.
 */
class Retention implements DocumentInterface
{
    /**
     * Serie del Documento (ejem: R001).
     *
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $correlativo;

    /**
     * @var \DateTimeInterface
     */
    private $fechaEmision;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var Client
     */
    private $proveedor;

    /**
     * @var string
     */
    private $regimen;

    /**
     * @var float
     */
    private $tasa;

    /**
     * Importe total Retenido.
     *
     * @var float
     */
    private $impRetenido;

    /**
     * Importe total Pagado.
     *
     * @var float
     */
    private $impPagado;

    /**
     * @var string
     */
    private $observacion;

    /**
     * Dato del Comprobante relacionado.
     *
     * @var RetentionDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     *
     * @return Retention
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
     * @return Retention
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * @param \DateTimeInterface $fechaEmision
     *
     * @return Retention
     */
    public function setFechaEmision(\DateTimeInterface $fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return Client
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param Client $proveedor
     *
     * @return Retention
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return Retention
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegimen()
    {
        return $this->regimen;
    }

    /**
     * @param string $regimen
     *
     * @return Retention
     */
    public function setRegimen($regimen)
    {
        $this->regimen = $regimen;

        return $this;
    }

    /**
     * @return float
     */
    public function getTasa()
    {
        return $this->tasa;
    }

    /**
     * @param float $tasa
     *
     * @return Retention
     */
    public function setTasa($tasa)
    {
        $this->tasa = $tasa;

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
     * @return Retention
     */
    public function setImpRetenido($impRetenido)
    {
        $this->impRetenido = $impRetenido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPagado()
    {
        return $this->impPagado;
    }

    /**
     * @param float $impPagado
     *
     * @return Retention
     */
    public function setImpPagado($impPagado)
    {
        $this->impPagado = $impPagado;

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
     * @return Retention
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return RetentionDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param RetentionDetail[] $details
     *
     * @return Retention
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName()
    {
        $parts = [
            $this->company->getRuc(),
            '20',
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

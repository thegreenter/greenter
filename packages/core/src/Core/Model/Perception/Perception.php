<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:38 AM.
 */

namespace Greenter\Model\Perception;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Perception.
 */
class Perception implements DocumentInterface
{
    /**
     * Serie del Documento (ejem: P001).
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
     * Importe total Percibido.
     *
     * @var float
     */
    private $impPercibido;

    /**
     * Importe total Cobrado.
     *
     * @var float
     */
    private $impCobrado;

    /**
     * @var string
     */
    private $observacion;

    /**
     * Dato del Comprobante relacionado.
     *
     * @var PerceptionDetail[]
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
     * @return Perception
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
     * @return Perception
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
     * @return Perception
     */
    public function setFechaEmision(\DateTimeInterface $fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

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
     * @return Perception
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

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
     * @return Perception
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

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
     * @return Perception
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
     * @return Perception
     */
    public function setTasa($tasa)
    {
        $this->tasa = $tasa;

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
     * @return Perception
     */
    public function setImpPercibido($impPercibido)
    {
        $this->impPercibido = $impPercibido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpCobrado()
    {
        return $this->impCobrado;
    }

    /**
     * @param float $impCobrado
     *
     * @return Perception
     */
    public function setImpCobrado($impCobrado)
    {
        $this->impCobrado = $impCobrado;

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
     * @return Perception
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return PerceptionDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param PerceptionDetail[] $details
     *
     * @return Perception
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
            '40',
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

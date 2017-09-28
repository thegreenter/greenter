<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:38 AM
 */

namespace Greenter\Model\Perception;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Xml\Validator\PerceptionValidator;

/**
 * Class Perception
 * @package Greenter\Model\Perception
 */
class Perception
{
    use PerceptionValidator;

    /**
     * Serie del Documento (ejem: P001)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="4")
     * @var string
     */
    private $serie;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    private $correlativo;

    /**
     * @Assert\Date()
     * @var \DateTime
     */
    private $fechaEmision;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Company
     */
    private $company;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Client
     */
    private $proveedor;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $regimen;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $tasa;

    /**
     * Importe total Percibido.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $impPercibido;

    /**
     * Importe total Cobrado.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $impCobrado;

    /**
     * @Assert\Length(max="250")
     * @var string
     */
    private $observacion;

    /**
     * Dato del Comprobante relacionado.
     *
     * @Assert\NotBlank()
     * @Assert\Valid()
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
     * @return Perception
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
     * @return Perception
     */
    public function setFechaEmision($fechaEmision)
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
     * @return Perception
     */
    public function setCompany($company)
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
    public function getFileName()
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
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:37 AM
 */

namespace Greenter\Model\Retention;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Xml\Validator\RetentionValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Retention
 * @package Greenter\Model\Retention
 */
class Retention implements DocumentInterface
{
    use RetentionValidator;

    /**
     * Serie del Documento (ejem: R001)
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
     * Importe total Retenido
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $impRetenido;

    /**
     * Importe total Pagado
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $impPagado;

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
     * @return Retention
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
     * @return Retention
     */
    public function setFechaEmision($fechaEmision)
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
     * @return Retention
     */
    public function setCompany($company)
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
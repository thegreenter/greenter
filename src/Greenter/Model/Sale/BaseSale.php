<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/07/2017
 * Time: 23:26
 */

namespace Greenter\Model\Sale;

/**
 * Class BaseSale
 * @package Greenter\Model\Sale
 */
class BaseSale
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="2")
     * @var string
     */
    protected $tipoDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="4")
     * @var string
     */
    protected $serie;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    protected $correlativo;

    /**
     * @Assert\Date()
     * @var \DateTime
     */
    protected $fechaEmision;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="1")
     * @var string
     */
    protected $tipoDocUsuario;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     * @var string
     */
    protected $numDocUsuario;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    protected $rznSocialUsuario;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @var string
     */
    protected $tipoMoneda;

    /**
     * @var float
     */
    protected $sumOtrosCargos;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    protected $mtoOperGravadas;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    protected $mtoOperInafectas;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    protected $mtoOperExoneradas;

    /**
     * @var float
     */
    protected $mtoIGV;

    /**
     * @var float
     */
    protected $mtoISC;

    /**
     * @var float
     */
    protected $mtoOtrosTributos;

    /**
     * Importe total de la venta, cesión en uso o del servicio prestado.
     *
     * @Assert\NotBlank()
     * @var float
     */
    protected $mtoImpVenta;

    /**
     * @Assert\Valid()
     * @var SaleDetail[]
     */
    protected $details;

    /**
     * @Assert\Valid()
     * @var Legend[]
     */
    protected $legends;

    /**
     * @Assert\Valid()
     * @var Document[]
     */
    protected $relDocs;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return BaseSale
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     * @return BaseSale
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
     * @return BaseSale
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
     * @return BaseSale
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoDocUsuario()
    {
        return $this->tipoDocUsuario;
    }

    /**
     * @param string $tipoDocUsuario
     * @return BaseSale
     */
    public function setTipoDocUsuario($tipoDocUsuario)
    {
        $this->tipoDocUsuario = $tipoDocUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumDocUsuario()
    {
        return $this->numDocUsuario;
    }

    /**
     * @param string $numDocUsuario
     * @return BaseSale
     */
    public function setNumDocUsuario($numDocUsuario)
    {
        $this->numDocUsuario = $numDocUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getRznSocialUsuario()
    {
        return $this->rznSocialUsuario;
    }

    /**
     * @param string $rznSocialUsuario
     * @return BaseSale
     */
    public function setRznSocialUsuario($rznSocialUsuario)
    {
        $this->rznSocialUsuario = $rznSocialUsuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    /**
     * @param mixed $tipoMoneda
     * @return BaseSale
     */
    public function setTipoMoneda($tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSumOtrosCargos()
    {
        return $this->sumOtrosCargos;
    }

    /**
     * @param mixed $sumOtrosCargos
     * @return BaseSale
     */
    public function setSumOtrosCargos($sumOtrosCargos)
    {
        $this->sumOtrosCargos = $sumOtrosCargos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoOperGravadas()
    {
        return $this->mtoOperGravadas;
    }

    /**
     * @param mixed $mtoOperGravadas
     * @return BaseSale
     */
    public function setMtoOperGravadas($mtoOperGravadas)
    {
        $this->mtoOperGravadas = $mtoOperGravadas;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoOperInafectas()
    {
        return $this->mtoOperInafectas;
    }

    /**
     * @param mixed $mtoOperInafectas
     * @return BaseSale
     */
    public function setMtoOperInafectas($mtoOperInafectas)
    {
        $this->mtoOperInafectas = $mtoOperInafectas;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperExoneradas()
    {
        return $this->mtoOperExoneradas;
    }

    /**
     * @param float $mtoOperExoneradas
     * @return BaseSale
     */
    public function setMtoOperExoneradas($mtoOperExoneradas)
    {
        $this->mtoOperExoneradas = $mtoOperExoneradas;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoIGV()
    {
        return $this->mtoIGV;
    }

    /**
     * @param mixed $mtoIGV
     * @return BaseSale
     */
    public function setMtoIGV($mtoIGV)
    {
        $this->mtoIGV = $mtoIGV;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoISC()
    {
        return $this->mtoISC;
    }

    /**
     * @param mixed $mtoISC
     * @return BaseSale
     */
    public function setMtoISC($mtoISC)
    {
        $this->mtoISC = $mtoISC;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOtrosTributos()
    {
        return $this->mtoOtrosTributos;
    }

    /**
     * @param float $mtoOtrosTributos
     * @return BaseSale
     */
    public function setMtoOtrosTributos($mtoOtrosTributos)
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoImpVenta()
    {
        return $this->mtoImpVenta;
    }

    /**
     * @param float $mtoImpVenta
     * @return BaseSale
     */
    public function setMtoImpVenta($mtoImpVenta)
    {
        $this->mtoImpVenta = $mtoImpVenta;
        return $this;
    }

    /**
     * @return SaleDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param SaleDetail[] $details
     * @return BaseSale
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return Legend[]
     */
    public function getLegends()
    {
        return $this->legends;
    }

    /**
     * @param Legend[] $legends
     * @return BaseSale
     */
    public function setLegends($legends)
    {
        $this->legends = $legends;
        return $this;
    }

    /**
     * @return Document[]
     */
    public function getRelDocs()
    {
        return $this->relDocs;
    }

    /**
     * @param Document[] $relDocs
     * @return BaseSale
     */
    public function setRelDocs($relDocs)
    {
        $this->relDocs = $relDocs;
        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05
 */

namespace Greenter\Xml\Model\Sale;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Invoice
 * @package Greenter\Xml\Model\Sale
 */
class Invoice
{
    /**
     * Tipo operacion (Catálogo 17).
     * @var string
     */
    private $tipoOperacion;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="2")
     * @var string
     */
    private $tipoDoc;

    /**
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
     * @Assert\Length(max="1")
     * @var string
     */
    private $tipoDocUsuario;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     * @var string
     */
    private $numDocUsuario;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    private $rznSocialUsuario;

    /**
     * @Assert\Length(max="100")
     * @var string
     */
    private $direccionUsuario;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="3")
     * @var string
     */
    private $tipoMoneda;

    /**
     * @var float
     */
    private $sumDsctoGlobal;

    /**
     * @var float
     */
    private $sumOtrosCargos;

    /**
     * @var float
     */
    private $mtoDescuentos;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoOperGravadas;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoOperInafectas;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoOperExoneradas;

    /**
     * @var float
     */
    private $mtoOperGratuitas;

    /**
     * @var float
     */
    private $mtoIGV;

    /**
     * @var float
     */
    private $mtoISC;

    /**
     * @var float
     */
    private $mtoOtrosTributos;

    /**
     * Importe total de la venta, cesión en uso o del servicio prestado.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoImpVenta;

    /**
     * @var string
     */
    private $codRegPercepcion;

    /**
     * @var float
     */
    private $mtoBaseImponiblePercepcion;

    /**
     * @var float
     */
    private $mtoPercepcion;

    /**
     * @var float
     */
    private $mtoTotalIncPercepcion;

    private $TipoDocGuia;

    private $NumDocGuia;

    /**
     * @Assert\All({
     *     @Assert\Valid()
     * })
     * @var SaleDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * @param string $tipoOperacion
     * @return Invoice
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
     */
    public function setRznSocialUsuario($rznSocialUsuario)
    {
        $this->rznSocialUsuario = $rznSocialUsuario;
        return $this;
    }

    /**
     * @return string
     */
    public function getDireccionUsuario()
    {
        return $this->direccionUsuario;
    }

    /**
     * @param string $direccionUsuario
     * @return Invoice
     */
    public function setDireccionUsuario($direccionUsuario)
    {
        $this->direccionUsuario = $direccionUsuario;
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
     * @return Invoice
     */
    public function setTipoMoneda($tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;
        return $this;
    }

    /**
     * @return float
     */
    public function getSumDsctoGlobal()
    {
        return $this->sumDsctoGlobal;
    }

    /**
     * @param float $sumDsctoGlobal
     * @return Invoice
     */
    public function setSumDsctoGlobal($sumDsctoGlobal)
    {
        $this->sumDsctoGlobal = $sumDsctoGlobal;
        return $this;
    }

    /**
     * @return float
     */
    public function getSumOtrosCargos()
    {
        return $this->sumOtrosCargos;
    }

    /**
     * @param float $sumOtrosCargos
     * @return Invoice
     */
    public function setSumOtrosCargos($sumOtrosCargos)
    {
        $this->sumOtrosCargos = $sumOtrosCargos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoDescuentos()
    {
        return $this->mtoDescuentos;
    }

    /**
     * @param mixed $mtoDescuentos
     * @return Invoice
     */
    public function setMtoDescuentos($mtoDescuentos)
    {
        $this->mtoDescuentos = $mtoDescuentos;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGravadas()
    {
        return $this->mtoOperGravadas;
    }

    /**
     * @param float $mtoOperGravadas
     * @return Invoice
     */
    public function setMtoOperGravadas($mtoOperGravadas)
    {
        $this->mtoOperGravadas = $mtoOperGravadas;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperInafectas()
    {
        return $this->mtoOperInafectas;
    }

    /**
     * @param float $mtoOperInafectas
     * @return Invoice
     */
    public function setMtoOperInafectas($mtoOperInafectas)
    {
        $this->mtoOperInafectas = $mtoOperInafectas;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMtoOperExoneradas()
    {
        return $this->mtoOperExoneradas;
    }

    /**
     * @param mixed $mtoOperExoneradas
     * @return Invoice
     */
    public function setMtoOperExoneradas($mtoOperExoneradas)
    {
        $this->mtoOperExoneradas = $mtoOperExoneradas;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGratuitas()
    {
        return $this->mtoOperGratuitas;
    }

    /**
     * @param float $mtoOperGratuitas
     * @return Invoice
     */
    public function setMtoOperGratuitas($mtoOperGratuitas)
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIGV()
    {
        return $this->mtoIGV;
    }

    /**
     * @param float $mtoIGV
     * @return Invoice
     */
    public function setMtoIGV($mtoIGV)
    {
        $this->mtoIGV = $mtoIGV;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoISC()
    {
        return $this->mtoISC;
    }

    /**
     * @param float $mtoISC
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
     */
    public function setMtoImpVenta($mtoImpVenta)
    {
        $this->mtoImpVenta = $mtoImpVenta;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodRegPercepcion()
    {
        return $this->codRegPercepcion;
    }

    /**
     * @param string $codRegPercepcion
     * @return Invoice
     */
    public function setCodRegPercepcion($codRegPercepcion)
    {
        $this->codRegPercepcion = $codRegPercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseImponiblePercepcion()
    {
        return $this->mtoBaseImponiblePercepcion;
    }

    /**
     * @param float $mtoBaseImponiblePercepcion
     * @return Invoice
     */
    public function setMtoBaseImponiblePercepcion($mtoBaseImponiblePercepcion)
    {
        $this->mtoBaseImponiblePercepcion = $mtoBaseImponiblePercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoPercepcion()
    {
        return $this->mtoPercepcion;
    }

    /**
     * @param float $mtoPercepcion
     * @return Invoice
     */
    public function setMtoPercepcion($mtoPercepcion)
    {
        $this->mtoPercepcion = $mtoPercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoTotalIncPercepcion()
    {
        return $this->mtoTotalIncPercepcion;
    }

    /**
     * @param float $mtoTotalIncPercepcion
     * @return Invoice
     */
    public function setMtoTotalIncPercepcion($mtoTotalIncPercepcion)
    {
        $this->mtoTotalIncPercepcion = $mtoTotalIncPercepcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoDocGuia()
    {
        return $this->TipoDocGuia;
    }

    /**
     * @param mixed $TipoDocGuia
     * @return Invoice
     */
    public function setTipoDocGuia($TipoDocGuia)
    {
        $this->TipoDocGuia = $TipoDocGuia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumDocGuia()
    {
        return $this->NumDocGuia;
    }

    /**
     * @param mixed $NumDocGuia
     * @return Invoice
     */
    public function setNumDocGuia($NumDocGuia)
    {
        $this->NumDocGuia = $NumDocGuia;
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
     * @return Invoice
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

}
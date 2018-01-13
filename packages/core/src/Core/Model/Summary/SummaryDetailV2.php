<?php
/**
 * Created by PhpStorm.
 * User: Admi
 * nistrador
 * Date: 04/10/2017
 * Time: 12:10 PM
 */

namespace Greenter\Model\Summary;

use Greenter\Model\Sale\Document;

/**
 * Class SummaryDetailV2
 * @package Greenter\Model\Summary
 */
class SummaryDetailV2
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $tipoDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="13")
     * @var string
     */
    private $serieNro;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="1")
     * @var string
     */
    private $clienteTipo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="20")
     * @var string
     */
    private $clienteNro;

    /**
     * Boleta de Venta que se modifica.
     *
     * @Assert\Valid()
     * @var Document
     */
    private $docReferencia;

    /**
     * @var SummaryPerception
     */
    private $percepcion;

    /**
     * Estado del item (catalog: 19).
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="1")
     * @var string
     */
    private $estado;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $total;

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
     * Otros Cargos.
     *
     * @var float
     */
    private $mtoOtrosCargos;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoIGV;

    /**
     * @Assert\NotBlank()
     * @var float
     */
    private $mtoISC;

    /**
     * @var float
     */
    private $mtoOtrosTributos;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return SummaryDetailV2
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerieNro()
    {
        return $this->serieNro;
    }

    /**
     * @param string $serieNro
     * @return SummaryDetailV2
     */
    public function setSerieNro($serieNro)
    {
        $this->serieNro = $serieNro;
        return $this;
    }

    /**
     * @return string
     */
    public function getClienteTipo()
    {
        return $this->clienteTipo;
    }

    /**
     * @param string $clienteTipo
     * @return SummaryDetailV2
     */
    public function setClienteTipo($clienteTipo)
    {
        $this->clienteTipo = $clienteTipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getClienteNro()
    {
        return $this->clienteNro;
    }

    /**
     * @param string $clienteNro
     * @return SummaryDetailV2
     */
    public function setClienteNro($clienteNro)
    {
        $this->clienteNro = $clienteNro;
        return $this;
    }

    /**
     * @return Document
     */
    public function getDocReferencia()
    {
        return $this->docReferencia;
    }

    /**
     * @param Document $docReferencia
     * @return SummaryDetailV2
     */
    public function setDocReferencia($docReferencia)
    {
        $this->docReferencia = $docReferencia;
        return $this;
    }

    /**
     * @return SummaryPerception
     */
    public function getPercepcion()
    {
        return $this->percepcion;
    }

    /**
     * @param SummaryPerception $percepcion
     * @return SummaryDetailV2
     */
    public function setPercepcion($percepcion)
    {
        $this->percepcion = $percepcion;
        return $this;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     * @return SummaryDetailV2
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
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
     * @return SummaryDetailV2
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
     * @return SummaryDetailV2
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
     * @return SummaryDetailV2
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
     * @return SummaryDetailV2
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
     * @return SummaryDetailV2
     */
    public function setMtoOperGratuitas($mtoOperGratuitas)
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOtrosCargos()
    {
        return $this->mtoOtrosCargos;
    }

    /**
     * @param float $mtoOtrosCargos
     * @return SummaryDetailV2
     */
    public function setMtoOtrosCargos($mtoOtrosCargos)
    {
        $this->mtoOtrosCargos = $mtoOtrosCargos;
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
     * @return SummaryDetailV2
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
     * @return SummaryDetailV2
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
     * @return SummaryDetailV2
     */
    public function setMtoOtrosTributos($mtoOtrosTributos)
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;
        return $this;
    }
}
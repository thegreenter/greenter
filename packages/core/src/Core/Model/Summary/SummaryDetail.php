<?php
/**
 * Created by PhpStorm.
 * User: Admi
 * nistrador
 * Date: 04/10/2017
 * Time: 12:10 PM.
 */

namespace Greenter\Model\Summary;

use Greenter\Model\Sale\Document;

/**
 * Class SummaryDetail.
 */
class SummaryDetail
{
    /**
     * @var string
     */
    private $tipoDoc;

    /**
     * @var string
     */
    private $serieNro;

    /**
     * @var string
     */
    private $clienteTipo;

    /**
     * @var string
     */
    private $clienteNro;

    /**
     * Boleta de Venta que se modifica.
     *
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
     *
     * @var string
     */
    private $estado;

    /**
     * @var float
     */
    private $total;

    /**
     * @var float
     */
    private $mtoOperGravadas;

    /**
     * @var float
     */
    private $mtoOperInafectas;

    /**
     * @var float
     */
    private $mtoOperExoneradas;

    /**
     * @var float
     */
    private $mtoOperExportacion;

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
     * @var float
     */
    private $mtoIGV;

    /**
     * @var float
     */
    private $mtoIvap;

    /**
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
     */
    public function setMtoOperExoneradas($mtoOperExoneradas)
    {
        $this->mtoOperExoneradas = $mtoOperExoneradas;

        return $this;
    }
    /**
     * @return float
     */
    public function getMtoOperExportacion()
    {
        return $this->mtoOperExportacion;
    }

    /**
     * @param float $mtoOperExportacion
     *
     * @return SummaryDetail
     */
    public function setMtoOperExportacion($mtoOperExportacion)
    {
        $this->mtoOperExportacion = $mtoOperExportacion;

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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
     */
    public function setMtoIGV($mtoIGV)
    {
        $this->mtoIGV = $mtoIGV;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIvap()
    {
        return $this->mtoIvap;
    }

    /**
     * @param float $mtoIvap
     * @return SummaryDetail
     */
    public function setMtoIvap($mtoIvap)
    {
        $this->mtoIvap = $mtoIvap;
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
     *
     * @return SummaryDetail
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
     *
     * @return SummaryDetail
     */
    public function setMtoOtrosTributos($mtoOtrosTributos)
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;

        return $this;
    }
}

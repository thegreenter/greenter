<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:12
 */

namespace Greenter\Model\Summary;

/**
 * Class SummaryDetail
 * @package Greenter\Model\Summary
 */
class SummaryDetail
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $tipoDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="4")
     * @var string
     */
    private $serie;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    private $docInicio;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    private $docFin;

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
    private $mtoOtrosCargos;

    /**
     * @Assert\NotBlank()
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
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
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
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     * @return SummaryDetail
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocInicio()
    {
        return $this->docInicio;
    }

    /**
     * @param string $docInicio
     * @return SummaryDetail
     */
    public function setDocInicio($docInicio)
    {
        $this->docInicio = $docInicio;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocFin()
    {
        return $this->docFin;
    }

    /**
     * @param string $docFin
     * @return SummaryDetail
     */
    public function setDocFin($docFin)
    {
        $this->docFin = $docFin;
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
     * @return SummaryDetail
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
    public function getMtoOtrosCargos()
    {
        return $this->mtoOtrosCargos;
    }

    /**
     * @param float $mtoOtrosCargos
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
     * @return SummaryDetail
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
     * @return SummaryDetail
     */
    public function setMtoOtrosTributos($mtoOtrosTributos)
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;
        return $this;
    }
}
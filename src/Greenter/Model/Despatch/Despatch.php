<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42
 */

namespace Greenter\Model\Despatch;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Document;
use Greenter\Xml\Validator\DespatchValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Despatch
 * @package Greenter\Model\Despatch
 */
class Despatch
{
    use DespatchValidator;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="2")
     * @var string
     */
    private $tipoDoc;

    /**
     * Serie del Documento (ejem: T001)
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
     * @Assert\Length(max="250")
     * @var string
     */
    private $observacion;
    /**
     * @Assert\Date()
     * @var \DateTime
     */
    private $fechaEmision;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Client
     */
    private $destinatario;

    /**
     * Datos del Establecimiento del tercero (cuando se ingrese)
     *
     * @Assert\Valid()
     * @var Client
     */
    private $tercero;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Shipment
     */
    private $envio;

    /**
     * @Assert\Valid()
     * @var Document
     */
    private $docBaja;

    /**
     * @Assert\Valid()
     * @var Document[]
     */
    private $relDocs;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var DespatchDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return Despatch
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
     * @return Despatch
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
     * @return Despatch
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;
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
     * @return Despatch
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
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
     * @return Despatch
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;
        return $this;
    }

    /**
     * @return Client
     */
    public function getDestinatario()
    {
        return $this->destinatario;
    }

    /**
     * @param Client $destinatario
     * @return Despatch
     */
    public function setDestinatario($destinatario)
    {
        $this->destinatario = $destinatario;
        return $this;
    }

    /**
     * @return Client
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param Client $tercero
     * @return Despatch
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
        return $this;
    }

    /**
     * @return Shipment
     */
    public function getEnvio()
    {
        return $this->envio;
    }

    /**
     * @param Shipment $envio
     * @return Despatch
     */
    public function setEnvio($envio)
    {
        $this->envio = $envio;
        return $this;
    }

    /**
     * @return Document
     */
    public function getDocBaja()
    {
        return $this->docBaja;
    }

    /**
     * @param Document $docBaja
     * @return Despatch
     */
    public function setDocBaja($docBaja)
    {
        $this->docBaja = $docBaja;
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
     * @return Despatch
     */
    public function setRelDocs($relDocs)
    {
        $this->relDocs = $relDocs;
        return $this;
    }

    /**
     * @return DespatchDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param DespatchDetail[] $details
     * @return Despatch
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Get FileName without extension.
     *
     * @param string $ruc Ruc de la Empresa.
     * @return string
     */
    public function getFileName($ruc)
    {
        $parts = [
            $ruc,
            $this->getTipoDoc(), // 09
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
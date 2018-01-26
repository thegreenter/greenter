<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42.
 */

namespace Greenter\Model\Despatch;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Document;

/**
 * Class Despatch.
 */
class Despatch implements DocumentInterface
{
    /**
     * @var string
     */
    private $tipoDoc;
    /**
     * Serie del Documento (ejem: T001).
     *
     *
     * @var string
     */
    private $serie;
    /**
     * @var string
     */
    private $correlativo;
    /**
     * @var string
     */
    private $observacion;
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
    private $destinatario;
    /**
     * Datos del Proveedor. (cuando se ingrese).
     *
     *
     * @var Client
     */
    private $tercero;
    /**
     * @var Shipment
     */
    private $envio;
    /**
     * @var Document
     */
    private $docBaja;
    /**
     * @var Document
     */
    private $relDoc;
    /**
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
     *
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
     *
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
     *
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
     *
     * @return Despatch
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

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
     * @return Despatch
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
     * @return Despatch
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

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
     *
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
     *
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
     *
     * @return Despatch
     */
    public function setEnvio(Shipment $envio)
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
     *
     * @return Despatch
     */
    public function setDocBaja($docBaja)
    {
        $this->docBaja = $docBaja;

        return $this;
    }

    /**
     * @return Document
     */
    public function getRelDoc()
    {
        return $this->relDoc;
    }

    /**
     * @param Document $relDoc
     *
     * @return Despatch
     */
    public function setRelDoc($relDoc)
    {
        $this->relDoc = $relDoc;

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
     *
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
     * @return string
     */
    public function getName()
    {
        $parts = [
            $this->company->getRuc(),
            $this->getTipoDoc(), // 09
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

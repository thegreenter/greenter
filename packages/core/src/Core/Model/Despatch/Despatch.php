<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 21:42.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

use DateTimeInterface;
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
    private $version;

    /**
     * @var string
     */
    private $tipoDoc;
    /**
     * Serie del Documento (ejem: T001).
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
     * @var DateTimeInterface
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
     * @var Client
     */
    private $tercero;
    /**
     * Datos del Comprador.
     *
     * @var Client
     */
    private $comprador;
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
     * @var AdditionalDoc[]
     */
    private $addDocs;
    /**
     * @var DespatchDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @param string|null $version
     * @return Despatch
     */
    public function setVersion(?string $version): Despatch
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return Despatch
     */
    public function setTipoDoc(?string $tipoDoc): Despatch
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     *
     * @return Despatch
     */
    public function setSerie(?string $serie): Despatch
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorrelativo(): ?string
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return Despatch
     */
    public function setCorrelativo(?string $correlativo): Despatch
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     *
     * @return Despatch
     */
    public function setObservacion(?string $observacion): Despatch
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFechaEmision(): ?DateTimeInterface
    {
        return $this->fechaEmision;
    }

    /**
     * @param DateTimeInterface $fechaEmision
     *
     * @return Despatch
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): Despatch
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return Despatch
     */
    public function setCompany(?Company $company): Despatch
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Client
     */
    public function getDestinatario(): ?Client
    {
        return $this->destinatario;
    }

    /**
     * @param Client $destinatario
     *
     * @return Despatch
     */
    public function setDestinatario(?Client $destinatario): Despatch
    {
        $this->destinatario = $destinatario;

        return $this;
    }

    /**
     * @return Client
     */
    public function getTercero(): ?Client
    {
        return $this->tercero;
    }

    /**
     * @param Client|null $tercero
     *
     * @return Despatch
     */
    public function setTercero(?Client $tercero): Despatch
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * @return Client
     */
    public function getComprador(): ?Client
    {
        return $this->comprador;
    }

    /**
     * @param Client|null $comprador
     *
     * @return Despatch
     */
    public function setComprador(?Client $comprador): Despatch
    {
        $this->comprador = $comprador;

        return $this;
    }

    /**
     * @return Shipment
     */
    public function getEnvio(): ?Shipment
    {
        return $this->envio;
    }

    /**
     * @param Shipment $envio
     *
     * @return Despatch
     */
    public function setEnvio(?Shipment $envio): Despatch
    {
        $this->envio = $envio;

        return $this;
    }

    /**
     * @return Document
     */
    public function getDocBaja(): ?Document
    {
        return $this->docBaja;
    }

    /**
     * @deprecated unused
     *
     * @param Document $docBaja
     *
     * @return Despatch
     */
    public function setDocBaja(?Document $docBaja): Despatch
    {
        $this->docBaja = $docBaja;

        return $this;
    }

    /**
     * @return Document
     */
    public function getRelDoc(): ?Document
    {
        return $this->relDoc;
    }

    /**
     * @deprecated use setAddDocs
     *
     * @param Document $relDoc
     *
     * @return Despatch
     */
    public function setRelDoc(?Document $relDoc): Despatch
    {
        $this->relDoc = $relDoc;

        return $this;
    }

    /**
     * @return AdditionalDoc[]
     */
    public function getAddDocs(): ?array
    {
        return $this->addDocs;
    }

    /**
     * @param AdditionalDoc[] $addDocs
     * @return Despatch
     */
    public function setAddDocs(?array $addDocs): Despatch
    {
        $this->addDocs = $addDocs;

        return $this;
    }

    /**
     * @return DespatchDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param DespatchDetail[] $details
     *
     * @return Despatch
     */
    public function setDetails(?array $details): Despatch
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName(): string
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

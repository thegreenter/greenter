<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/07/2017
 * Time: 23:26.
 */

namespace Greenter\Model\Sale;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class BaseSale.
 */
class BaseSale implements DocumentInterface
{
    /**
     * @var string
     */
    protected $tipoDoc;

    /**
     * @var string
     */
    protected $serie;

    /**
     * @var string
     */
    protected $correlativo;

    /**
     * @var \DateTimeInterface
     */
    protected $fechaEmision;

    /**
     * @var Company
     */
    protected $company;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $tipoMoneda;

    /**
     * @var float
     */
    protected $sumOtrosCargos;

    /**
     * @var float
     */
    protected $mtoOperGravadas;

    /**
     * @var float
     */
    protected $mtoOperInafectas;

    /**
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
     * @var float
     */
    protected $mtoImpVenta;

    /**
     * @var SaleDetail[]
     */
    protected $details;

    /**
     * @var Legend[]
     */
    protected $legends;

    /**
     * Guias de Remision relacionado (caso de uso en venta itinerante).
     *
     * @var Document[]
     */
    protected $guias;

    /**
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
     *
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
     *
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
     *
     * @return BaseSale
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

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
     * @return BaseSale
     */
    public function setFechaEmision(\DateTimeInterface $fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     *
     * @return BaseSale
     */
    public function setClient($client)
    {
        $this->client = $client;

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
     * @return BaseSale
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
    public function getGuias()
    {
        return $this->guias;
    }

    /**
     * @param Document[] $guias
     * @return BaseSale
     */
    public function setGuias($guias)
    {
        $this->guias = $guias;
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
     *
     * @return BaseSale
     */
    public function setRelDocs($relDocs)
    {
        $this->relDocs = $relDocs;

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
            $this->getTipoDoc(),
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

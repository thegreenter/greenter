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
    protected $ublVersion = '2.0';

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
    protected $mtoOperExportacion;

    /**
     * @var float
     */
    protected $mtoIGV;

    /**
     * @var float
     */
    protected $mtoBaseIsc;

    /**
     * @var float
     */
    protected $mtoISC;

    /**
     * @var float
     */
    protected $mtoBaseOth;

    /**
     * @var float
     */
    protected $mtoOtrosTributos;

    /**
     * @var float
     */
    protected $totalImpuestos;

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
     * Orden de Compra relacionado.
     *
     * @var string
     */
    protected $compra;

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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoMoneda()
    {
        return $this->tipoMoneda;
    }

    /**
     * @param string $tipoMoneda
     *
     * @return $this
     */
    public function setTipoMoneda($tipoMoneda)
    {
        $this->tipoMoneda = $tipoMoneda;

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
     *
     * @return $this
     */
    public function setSumOtrosCargos($sumOtrosCargos)
    {
        $this->sumOtrosCargos = $sumOtrosCargos;

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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setMtoOperExportacion($mtoOperExportacion)
    {
        $this->mtoOperExportacion = $mtoOperExportacion;
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
     * @return $this
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
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setRelDocs($relDocs)
    {
        $this->relDocs = $relDocs;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * @param string $compra
     *
     * @return $this
     */
    public function setCompra($compra)
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIsc()
    {
        return $this->mtoBaseIsc;
    }

    /**
     * Set Monto Base ISC.
     *
     * @param float $mtoBaseIsc
     * @return $this
     */
    public function setMtoBaseIsc($mtoBaseIsc)
    {
        $this->mtoBaseIsc = $mtoBaseIsc;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseOth()
    {
        return $this->mtoBaseOth;
    }

    /**
     * Set Monto base otros tributos.
     *
     * @param float $mtoBaseOth
     * @return $this
     */
    public function setMtoBaseOth($mtoBaseOth)
    {
        $this->mtoBaseOth = $mtoBaseOth;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalImpuestos()
    {
        return $this->totalImpuestos;
    }

    /**
     * @param float $totalImpuestos
     * @return $this
     */
    public function setTotalImpuestos($totalImpuestos)
    {
        $this->totalImpuestos = $totalImpuestos;
        return $this;
    }

    /**
     * @return string
     */
    public function getUblVersion()
    {
        return $this->ublVersion;
    }

    /**
     * @param string $ublVersion
     * @return $this
     */
    public function setUblVersion($ublVersion)
    {
        $this->ublVersion = $ublVersion;
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

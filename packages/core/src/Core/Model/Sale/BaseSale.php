<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/07/2017
 * Time: 23:26.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

use DateTimeInterface;
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
     * @var DateTimeInterface
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
    protected $mtoOperGratuitas;

    /**
     * @var float
     */
    protected $mtoIGVGratuitas;

    /**
     * @var float
     */
    protected $mtoIGV;

    /**
     * @var float
     */
    protected $mtoBaseIvap;

    /**
     * @var float
     */
    protected $mtoIvap;

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
    protected $icbper;

    /**
     * @var float
     */
    protected $totalImpuestos;

    /**
     * @var float
     */
    protected $redondeo;

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
     * @var PaymentTerms|null
     */
    protected $formaPago;

    /**
     * @var Cuota[]|null
     */
    protected $cuotas;

    /**
     * @return string
     */
    public function getUblVersion(): ?string
    {
        return $this->ublVersion;
    }

    /**
     * @param string $ublVersion
     *
     * @return $this
     */
    public function setUblVersion(?string $ublVersion): self
    {
        $this->ublVersion = $ublVersion;

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
     * @return $this
     */
    public function setTipoDoc(?string $tipoDoc): self
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
     * @return $this
     */
    public function setSerie(?string $serie): self
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
     * @return $this
     */
    public function setCorrelativo(?string $correlativo): self
    {
        $this->correlativo = $correlativo;

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
     * @return $this
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): self
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
     * @return $this
     */
    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     *
     * @return $this
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return string
     */
    public function getTipoMoneda(): ?string
    {
        return $this->tipoMoneda;
    }

    /**
     * @param string $tipoMoneda
     *
     * @return $this
     */
    public function setTipoMoneda(?string $tipoMoneda): self
    {
        $this->tipoMoneda = $tipoMoneda;

        return $this;
    }

    /**
     * @return float
     */
    public function getSumOtrosCargos(): ?float
    {
        return $this->sumOtrosCargos;
    }

    /**
     * @param float $sumOtrosCargos
     *
     * @return $this
     */
    public function setSumOtrosCargos(?float $sumOtrosCargos): self
    {
        $this->sumOtrosCargos = $sumOtrosCargos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGravadas(): ?float
    {
        return $this->mtoOperGravadas;
    }

    /**
     * @param float $mtoOperGravadas
     *
     * @return $this
     */
    public function setMtoOperGravadas(?float $mtoOperGravadas): self
    {
        $this->mtoOperGravadas = $mtoOperGravadas;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperInafectas(): ?float
    {
        return $this->mtoOperInafectas;
    }

    /**
     * @param float $mtoOperInafectas
     *
     * @return $this
     */
    public function setMtoOperInafectas(?float $mtoOperInafectas): self
    {
        $this->mtoOperInafectas = $mtoOperInafectas;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperExoneradas(): ?float
    {
        return $this->mtoOperExoneradas;
    }

    /**
     * @param float $mtoOperExoneradas
     *
     * @return $this
     */
    public function setMtoOperExoneradas(?float $mtoOperExoneradas): self
    {
        $this->mtoOperExoneradas = $mtoOperExoneradas;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperExportacion(): ?float
    {
        return $this->mtoOperExportacion;
    }

    /**
     * @param float $mtoOperExportacion
     *
     * @return $this
     */
    public function setMtoOperExportacion(?float $mtoOperExportacion): self
    {
        $this->mtoOperExportacion = $mtoOperExportacion;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGratuitas(): ?float
    {
        return $this->mtoOperGratuitas;
    }

    /**
     * @param float $mtoOperGratuitas
     *
     * @return $this
     */
    public function setMtoOperGratuitas(?float $mtoOperGratuitas): self
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIGVGratuitas(): ?float
    {
        return $this->mtoIGVGratuitas;
    }

    /**
     * @param float $mtoIGVGratuitas
     *
     * @return $this
     */
    public function setMtoIGVGratuitas(?float $mtoIGVGratuitas): self
    {
        $this->mtoIGVGratuitas = $mtoIGVGratuitas;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIGV(): ?float
    {
        return $this->mtoIGV;
    }

    /**
     * @param float $mtoIGV
     *
     * @return $this
     */
    public function setMtoIGV(?float $mtoIGV): self
    {
        $this->mtoIGV = $mtoIGV;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIvap(): ?float
    {
        return $this->mtoBaseIvap;
    }

    /**
     * @param float $mtoBaseIvap
     *
     * @return $this
     */
    public function setMtoBaseIvap(?float $mtoBaseIvap): self
    {
        $this->mtoBaseIvap = $mtoBaseIvap;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIvap(): ?float
    {
        return $this->mtoIvap;
    }

    /**
     * @param float $mtoIvap
     *
     * @return $this
     */
    public function setMtoIvap(?float $mtoIvap): self
    {
        $this->mtoIvap = $mtoIvap;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseIsc(): ?float
    {
        return $this->mtoBaseIsc;
    }

    /**
     * @param float $mtoBaseIsc
     *
     * @return $this
     */
    public function setMtoBaseIsc(?float $mtoBaseIsc): self
    {
        $this->mtoBaseIsc = $mtoBaseIsc;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoISC(): ?float
    {
        return $this->mtoISC;
    }

    /**
     * @param float $mtoISC
     *
     * @return $this
     */
    public function setMtoISC(?float $mtoISC): self
    {
        $this->mtoISC = $mtoISC;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBaseOth(): ?float
    {
        return $this->mtoBaseOth;
    }

    /**
     * @param float $mtoBaseOth
     *
     * @return $this
     */
    public function setMtoBaseOth(?float $mtoBaseOth): self
    {
        $this->mtoBaseOth = $mtoBaseOth;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOtrosTributos(): ?float
    {
        return $this->mtoOtrosTributos;
    }

    /**
     * @param float $mtoOtrosTributos
     *
     * @return $this
     */
    public function setMtoOtrosTributos(?float $mtoOtrosTributos): self
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;

        return $this;
    }

    /**
     * @return float
     */
    public function getIcbper(): ?float
    {
        return $this->icbper;
    }

    /**
     * @param float $icbper
     *
     * @return $this
     */
    public function setIcbper(?float $icbper): self
    {
        $this->icbper = $icbper;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalImpuestos(): ?float
    {
        return $this->totalImpuestos;
    }

    /**
     * @param float $totalImpuestos
     *
     * @return $this
     */
    public function setTotalImpuestos(?float $totalImpuestos): self
    {
        $this->totalImpuestos = $totalImpuestos;

        return $this;
    }

    /**
     * @return float
     */
    public function getRedondeo(): ?float
    {
        return $this->redondeo;
    }

    /**
     * @param float $redondeo
     *
     * @return $this
     */
    public function setRedondeo(?float $redondeo): self
    {
        $this->redondeo = $redondeo;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoImpVenta(): ?float
    {
        return $this->mtoImpVenta;
    }

    /**
     * @param float $mtoImpVenta
     *
     * @return $this
     */
    public function setMtoImpVenta(?float $mtoImpVenta): self
    {
        $this->mtoImpVenta = $mtoImpVenta;

        return $this;
    }

    /**
     * @return SaleDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param SaleDetail[] $details
     *
     * @return $this
     */
    public function setDetails(?array $details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return Legend[]
     */
    public function getLegends(): ?array
    {
        return $this->legends;
    }

    /**
     * @param Legend[] $legends
     *
     * @return $this
     */
    public function setLegends(?array $legends): self
    {
        $this->legends = $legends;

        return $this;
    }

    /**
     * @return Document[]
     */
    public function getGuias(): ?array
    {
        return $this->guias;
    }

    /**
     * @param Document[] $guias
     *
     * @return $this
     */
    public function setGuias(?array $guias): self
    {
        $this->guias = $guias;

        return $this;
    }

    /**
     * @return Document[]
     */
    public function getRelDocs(): ?array
    {
        return $this->relDocs;
    }

    /**
     * @param Document[] $relDocs
     *
     * @return $this
     */
    public function setRelDocs(?array $relDocs): self
    {
        $this->relDocs = $relDocs;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompra(): ?string
    {
        return $this->compra;
    }

    /**
     * @param string $compra
     *
     * @return $this
     */
    public function setCompra(?string $compra): self
    {
        $this->compra = $compra;

        return $this;
    }

    /**
     * @return PaymentTerms|null
     */
    public function getFormaPago(): ?PaymentTerms
    {
        return $this->formaPago;
    }

    /**
     * @param PaymentTerms|null $formaPago
     * @return $this
     */
    public function setFormaPago(?PaymentTerms $formaPago): self
    {
        $this->formaPago = $formaPago;
        return $this;
    }

    /**
     * @return Cuota[]|null
     */
    public function getCuotas(): ?array
    {
        return $this->cuotas;
    }

    /**
     * @param Cuota[]|null $cuotas
     * @return $this
     */
    public function setCuotas(?array $cuotas): self
    {
        $this->cuotas = $cuotas;
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
            $this->getTipoDoc(),
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

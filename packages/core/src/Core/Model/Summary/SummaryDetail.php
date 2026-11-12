<?php
/**
 * Created by PhpStorm.
 * User: Admi
 * nistrador
 * Date: 04/10/2017
 * Time: 12:10 PM.
 */

declare(strict_types=1);

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
     * Apellidos y nombres, denominación o razón social del adquiriente o usuario.
     *
     * @var string|null
     */
    private $clienteNombre;

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
     * @var string
     */
    private $estado;

    /**
     * @var float
     */
    private $total;

    /**
     * @var ?float
     */
    private ?float $porcentajeIgv = null;

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
     * Operaciones gratuitas gravadas (catálogo 11: 06).
     *
     * @var float|null
     */
    private $mtoOperGratuitasGravadas;

    /**
     * Operaciones gratuitas exoneradas (catálogo 11: 07).
     *
     * @var float|null
     */
    private $mtoOperGratuitasExoneradas;

    /**
     * Operaciones gratuitas inafectas (catálogo 11: 08).
     *
     * @var float|null
     */
    private $mtoOperGratuitasInafectas;

    /**
     * Operaciones gratuitas de exportación (catálogo 11: 09).
     *
     * @var float|null
     */
    private $mtoOperGratuitasExportacion;

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
     * IGV de las operaciones gratuitas (tributo 9996 - GRA).
     *
     * Usa porcentajeIgv como tasa del tributo (regla 2992).
     *
     * @var float|null
     */
    private $mtoIGVGratuitas;

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
     * @var float
     */
    private $mtoIcbper;

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
     * @return SummaryDetail
     */
    public function setTipoDoc(?string $tipoDoc): SummaryDetail
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerieNro(): ?string
    {
        return $this->serieNro;
    }

    /**
     * @param string $serieNro
     *
     * @return SummaryDetail
     */
    public function setSerieNro(?string $serieNro): SummaryDetail
    {
        $this->serieNro = $serieNro;

        return $this;
    }

    /**
     * @return string
     */
    public function getClienteTipo(): ?string
    {
        return $this->clienteTipo;
    }

    /**
     * @param string $clienteTipo
     *
     * @return SummaryDetail
     */
    public function setClienteTipo(?string $clienteTipo): SummaryDetail
    {
        $this->clienteTipo = $clienteTipo;

        return $this;
    }

    /**
     * @return string
     */
    public function getClienteNro(): ?string
    {
        return $this->clienteNro;
    }

    /**
     * @param string $clienteNro
     *
     * @return SummaryDetail
     */
    public function setClienteNro(?string $clienteNro): SummaryDetail
    {
        $this->clienteNro = $clienteNro;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClienteNombre(): ?string
    {
        return $this->clienteNombre;
    }

    /**
     * @param string|null $clienteNombre
     *
     * @return SummaryDetail
     */
    public function setClienteNombre(?string $clienteNombre): SummaryDetail
    {
        $this->clienteNombre = $clienteNombre;

        return $this;
    }

    /**
     * @return Document
     */
    public function getDocReferencia(): ?Document
    {
        return $this->docReferencia;
    }

    /**
     * @param Document $docReferencia
     *
     * @return SummaryDetail
     */
    public function setDocReferencia(?Document $docReferencia): SummaryDetail
    {
        $this->docReferencia = $docReferencia;

        return $this;
    }

    /**
     * @return SummaryPerception
     */
    public function getPercepcion(): ?SummaryPerception
    {
        return $this->percepcion;
    }

    /**
     * @param SummaryPerception $percepcion
     *
     * @return SummaryDetail
     */
    public function setPercepcion(?SummaryPerception $percepcion): SummaryDetail
    {
        $this->percepcion = $percepcion;

        return $this;
    }

    /**
     * @return string
     */
    public function getEstado(): ?string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     *
     * @return SummaryDetail
     */
    public function setEstado(?string $estado): SummaryDetail
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * @param float $total
     *
     * @return SummaryDetail
     */
    public function setTotal(?float $total): SummaryDetail
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return float
     */
    public function getPorcentajeIgv(): ?float
    {
        return $this->porcentajeIgv;
    }

    /**
     * @param float $porcentajeIgv
     *
     * @return SummaryDetail
     */
    public function setPorcentajeIgv(?float $porcentajeIgv): SummaryDetail
    {
        $this->porcentajeIgv = $porcentajeIgv;

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
     * @return SummaryDetail
     */
    public function setMtoOperGravadas(?float $mtoOperGravadas): SummaryDetail
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
     * @return SummaryDetail
     */
    public function setMtoOperInafectas(?float $mtoOperInafectas): SummaryDetail
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
     * @return SummaryDetail
     */
    public function setMtoOperExoneradas(?float $mtoOperExoneradas): SummaryDetail
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
     * @return SummaryDetail
     */
    public function setMtoOperExportacion(?float $mtoOperExportacion): SummaryDetail
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
     * @return SummaryDetail
     */
    public function setMtoOperGratuitas(?float $mtoOperGratuitas): SummaryDetail
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoOperGratuitasGravadas(): ?float
    {
        return $this->mtoOperGratuitasGravadas;
    }

    /**
     * @param float|null $mtoOperGratuitasGravadas
     *
     * @return SummaryDetail
     */
    public function setMtoOperGratuitasGravadas(?float $mtoOperGratuitasGravadas): SummaryDetail
    {
        $this->mtoOperGratuitasGravadas = $mtoOperGratuitasGravadas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoOperGratuitasExoneradas(): ?float
    {
        return $this->mtoOperGratuitasExoneradas;
    }

    /**
     * @param float|null $mtoOperGratuitasExoneradas
     *
     * @return SummaryDetail
     */
    public function setMtoOperGratuitasExoneradas(?float $mtoOperGratuitasExoneradas): SummaryDetail
    {
        $this->mtoOperGratuitasExoneradas = $mtoOperGratuitasExoneradas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoOperGratuitasInafectas(): ?float
    {
        return $this->mtoOperGratuitasInafectas;
    }

    /**
     * @param float|null $mtoOperGratuitasInafectas
     *
     * @return SummaryDetail
     */
    public function setMtoOperGratuitasInafectas(?float $mtoOperGratuitasInafectas): SummaryDetail
    {
        $this->mtoOperGratuitasInafectas = $mtoOperGratuitasInafectas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoOperGratuitasExportacion(): ?float
    {
        return $this->mtoOperGratuitasExportacion;
    }

    /**
     * @param float|null $mtoOperGratuitasExportacion
     *
     * @return SummaryDetail
     */
    public function setMtoOperGratuitasExportacion(?float $mtoOperGratuitasExportacion): SummaryDetail
    {
        $this->mtoOperGratuitasExportacion = $mtoOperGratuitasExportacion;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOtrosCargos(): ?float
    {
        return $this->mtoOtrosCargos;
    }

    /**
     * @param float $mtoOtrosCargos
     *
     * @return SummaryDetail
     */
    public function setMtoOtrosCargos(?float $mtoOtrosCargos): SummaryDetail
    {
        $this->mtoOtrosCargos = $mtoOtrosCargos;

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
     * @return SummaryDetail
     */
    public function setMtoIGV(?float $mtoIGV): SummaryDetail
    {
        $this->mtoIGV = $mtoIGV;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoIGVGratuitas(): ?float
    {
        return $this->mtoIGVGratuitas;
    }

    /**
     * @param float|null $mtoIGVGratuitas
     *
     * @return SummaryDetail
     */
    public function setMtoIGVGratuitas(?float $mtoIGVGratuitas): SummaryDetail
    {
        $this->mtoIGVGratuitas = $mtoIGVGratuitas;

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
     * @return SummaryDetail
     */
    public function setMtoIvap(?float $mtoIvap): SummaryDetail
    {
        $this->mtoIvap = $mtoIvap;

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
     * @return SummaryDetail
     */
    public function setMtoISC(?float $mtoISC): SummaryDetail
    {
        $this->mtoISC = $mtoISC;

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
     * @return SummaryDetail
     */
    public function setMtoOtrosTributos(?float $mtoOtrosTributos): SummaryDetail
    {
        $this->mtoOtrosTributos = $mtoOtrosTributos;

        return $this;
    }

    /**
     * @return float
     */
    public function getMtoIcbper(): ?float
    {
        return $this->mtoIcbper;
    }

    /**
     * @param float $mtoIcbper
     *
     * @return SummaryDetail
     */
    public function setMtoIcbper(?float $mtoIcbper): SummaryDetail
    {
        $this->mtoIcbper = $mtoIcbper;

        return $this;
    }
}

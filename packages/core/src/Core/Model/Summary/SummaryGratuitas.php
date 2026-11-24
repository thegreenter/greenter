<?php

declare(strict_types=1);

namespace Greenter\Model\Summary;

/**
 * Operaciones gratuitas de una línea del resumen diario.
 *
 * Desagregado según las reglas de validación SUNAT (26.08.2026), reemplaza al
 * código 05 "Gratuitas" del catálogo 11, desactivado a partir del 2027-01-01.
 */
class SummaryGratuitas
{
    /**
     * Operaciones gratuitas gravadas (catálogo 11: 06).
     *
     * @var float|null
     */
    private $mtoGravadas;

    /**
     * Operaciones gratuitas exoneradas (catálogo 11: 07).
     *
     * @var float|null
     */
    private $mtoExoneradas;

    /**
     * Operaciones gratuitas inafectas (catálogo 11: 08).
     *
     * @var float|null
     */
    private $mtoInafectas;

    /**
     * Operaciones gratuitas de exportación (catálogo 11: 09).
     *
     * @var float|null
     */
    private $mtoExportacion;

    /**
     * IGV de las operaciones gratuitas (tributo 9996 - GRA).
     *
     * La tasa del tributo se toma de SummaryDetail::porcentajeIgv (regla 2992).
     *
     * @var float|null
     */
    private $mtoIgv;

    /**
     * @return float|null
     */
    public function getMtoGravadas(): ?float
    {
        return $this->mtoGravadas;
    }

    /**
     * @param float|null $mtoGravadas
     *
     * @return SummaryGratuitas
     */
    public function setMtoGravadas(?float $mtoGravadas): SummaryGratuitas
    {
        $this->mtoGravadas = $mtoGravadas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoExoneradas(): ?float
    {
        return $this->mtoExoneradas;
    }

    /**
     * @param float|null $mtoExoneradas
     *
     * @return SummaryGratuitas
     */
    public function setMtoExoneradas(?float $mtoExoneradas): SummaryGratuitas
    {
        $this->mtoExoneradas = $mtoExoneradas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoInafectas(): ?float
    {
        return $this->mtoInafectas;
    }

    /**
     * @param float|null $mtoInafectas
     *
     * @return SummaryGratuitas
     */
    public function setMtoInafectas(?float $mtoInafectas): SummaryGratuitas
    {
        $this->mtoInafectas = $mtoInafectas;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoExportacion(): ?float
    {
        return $this->mtoExportacion;
    }

    /**
     * @param float|null $mtoExportacion
     *
     * @return SummaryGratuitas
     */
    public function setMtoExportacion(?float $mtoExportacion): SummaryGratuitas
    {
        $this->mtoExportacion = $mtoExportacion;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getMtoIgv(): ?float
    {
        return $this->mtoIgv;
    }

    /**
     * @param float|null $mtoIgv
     *
     * @return SummaryGratuitas
     */
    public function setMtoIgv(?float $mtoIgv): SummaryGratuitas
    {
        $this->mtoIgv = $mtoIgv;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Un vehículo de un tramo de un servicio de transporte de carga (campos 123 a 126 y 128 de
 * «Factura2_0», /Invoice/cac:InvoiceLine/cac:Delivery/cac:Shipment/cac:Consignment/cac:TransportHandlingUnit).
 */
class VehiculoTransporte
{
    /**
     * Configuración vehicular, códigos del D.S. 058-2003-MTC (campo 123, cac:TransportEquipment/cbc:SizeTypeCode).
     *
     * @var string|null
     */
    private $configuracion;

    /**
     * Carga útil en toneladas métricas (campo 124, cac:MeasurementDimension con cbc:AttributeID 01).
     *
     * @var float|null
     */
    private $cargaUtil;

    /**
     * Carga efectiva en toneladas métricas (campo 125, cac:MeasurementDimension con cbc:AttributeID 02).
     *
     * @var float|null
     */
    private $cargaEfectiva;

    /**
     * Valor referencial por tonelada métrica, Anexo II del D.S. 010-2006-MTC (campo 126, cac:TransportEquipment/cac:Delivery/cac:DeliveryTerms/cbc:Amount).
     *
     * @var float|null
     */
    private $valorReferencialTm;

    /**
     * Indicador de aplicación del factor de retorno al vacío (campo 128, cac:TransportEquipment/cbc:ReturnabilityIndicator).
     *
     * @var bool|null
     */
    private $retornoVacio;

    /**
     * @return string|null
     */
    public function getConfiguracion(): ?string
    {
        return $this->configuracion;
    }

    /**
     * @param string|null $configuracion
     *
     * @return VehiculoTransporte
     */
    public function setConfiguracion(?string $configuracion): VehiculoTransporte
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCargaUtil(): ?float
    {
        return $this->cargaUtil;
    }

    /**
     * @param float|null $cargaUtil
     *
     * @return VehiculoTransporte
     */
    public function setCargaUtil(?float $cargaUtil): VehiculoTransporte
    {
        $this->cargaUtil = $cargaUtil;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCargaEfectiva(): ?float
    {
        return $this->cargaEfectiva;
    }

    /**
     * @param float|null $cargaEfectiva
     *
     * @return VehiculoTransporte
     */
    public function setCargaEfectiva(?float $cargaEfectiva): VehiculoTransporte
    {
        $this->cargaEfectiva = $cargaEfectiva;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorReferencialTm(): ?float
    {
        return $this->valorReferencialTm;
    }

    /**
     * @param float|null $valorReferencialTm
     *
     * @return VehiculoTransporte
     */
    public function setValorReferencialTm(?float $valorReferencialTm): VehiculoTransporte
    {
        $this->valorReferencialTm = $valorReferencialTm;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function isRetornoVacio(): ?bool
    {
        return $this->retornoVacio;
    }

    /**
     * @param bool|null $retornoVacio
     *
     * @return VehiculoTransporte
     */
    public function setRetornoVacio(?bool $retornoVacio): VehiculoTransporte
    {
        $this->retornoVacio = $retornoVacio;

        return $this;
    }
}

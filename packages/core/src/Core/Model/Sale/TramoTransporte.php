<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Un tramo del viaje de un servicio de transporte de carga (campos 119 a 122 y 127 de «Factura2_0»,
 * /Invoice/cac:InvoiceLine/cac:Delivery/cac:Shipment/cac:Consignment), con sus vehículos.
 */
class TramoTransporte
{
    /**
     * Identificador del tramo (cac:Consignment/cbc:ID, n2).
     *
     * @var string|null
     */
    private $id;

    /**
     * Punto de origen del viaje (campo 119, cac:PlannedPickupTransportEvent/cac:Location/cbc:ID).
     *
     * @var string|null
     */
    private $ubigeoOrigen;

    /**
     * Punto de destino del viaje (campo 120, cac:PlannedDeliveryTransportEvent/cac:Location/cbc:ID).
     *
     * @var string|null
     */
    private $ubigeoDestino;

    /**
     * Descripción del tramo (campo 121, cbc:CarrierServiceInstructions).
     *
     * @var string|null
     */
    private $descripcion;

    /**
     * Valor preliminar referencial sobre la carga efectiva por el tramo virtual recorrido (campo 122, cac:DeliveryTerms/cbc:Amount).
     *
     * @var float|null
     */
    private $valorCargaEfectiva;

    /**
     * Valor preliminar referencial por carga útil nominal, tratándose de más de un vehículo (campo 127, cbc:DeclaredForCarriageValueAmount).
     *
     * @var float|null
     */
    private $valorCargaNominal;

    /**
     * Los vehículos del tramo (campos 123 a 126 y 128, cac:TransportHandlingUnit).
     *
     * @var VehiculoTransporte[]|null
     */
    private $vehiculos;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     *
     * @return TramoTransporte
     */
    public function setId(?string $id): TramoTransporte
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUbigeoOrigen(): ?string
    {
        return $this->ubigeoOrigen;
    }

    /**
     * @param string|null $ubigeoOrigen
     *
     * @return TramoTransporte
     */
    public function setUbigeoOrigen(?string $ubigeoOrigen): TramoTransporte
    {
        $this->ubigeoOrigen = $ubigeoOrigen;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUbigeoDestino(): ?string
    {
        return $this->ubigeoDestino;
    }

    /**
     * @param string|null $ubigeoDestino
     *
     * @return TramoTransporte
     */
    public function setUbigeoDestino(?string $ubigeoDestino): TramoTransporte
    {
        $this->ubigeoDestino = $ubigeoDestino;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * @param string|null $descripcion
     *
     * @return TramoTransporte
     */
    public function setDescripcion(?string $descripcion): TramoTransporte
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorCargaEfectiva(): ?float
    {
        return $this->valorCargaEfectiva;
    }

    /**
     * @param float|null $valorCargaEfectiva
     *
     * @return TramoTransporte
     */
    public function setValorCargaEfectiva(?float $valorCargaEfectiva): TramoTransporte
    {
        $this->valorCargaEfectiva = $valorCargaEfectiva;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorCargaNominal(): ?float
    {
        return $this->valorCargaNominal;
    }

    /**
     * @param float|null $valorCargaNominal
     *
     * @return TramoTransporte
     */
    public function setValorCargaNominal(?float $valorCargaNominal): TramoTransporte
    {
        $this->valorCargaNominal = $valorCargaNominal;

        return $this;
    }

    /**
     * @return VehiculoTransporte[]|null
     */
    public function getVehiculos(): ?array
    {
        return $this->vehiculos;
    }

    /**
     * @param VehiculoTransporte[]|null $vehiculos
     *
     * @return TramoTransporte
     */
    public function setVehiculos(?array $vehiculos): TramoTransporte
    {
        $this->vehiculos = $vehiculos;

        return $this;
    }
}

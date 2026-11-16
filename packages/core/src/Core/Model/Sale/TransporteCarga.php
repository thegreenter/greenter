<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

use Greenter\Model\Company\Address;

/**
 * Detracción del servicio de transporte de carga (tipo de operación 1004) de una línea.
 *
 * Campos 113 a 118 de «Factura2_0» (/Invoice/cac:InvoiceLine/cac:Delivery): el origen y el
 * destino del viaje, su detalle y los tres valores referenciales; y los tramos (119 a 128).
 */
class TransporteCarga
{
    /**
     * Punto de origen: ubigeo y dirección detallada (campo 113, cac:Despatch/cac:DespatchAddress).
     *
     * @var Address|null
     */
    private $origen;

    /**
     * Punto de destino: ubigeo y dirección detallada (campo 114, cac:DeliveryLocation/cac:Address).
     *
     * @var Address|null
     */
    private $destino;

    /**
     * Detalle del viaje (campo 115, cac:Despatch/cbc:Instructions).
     *
     * @var string|null
     */
    private $detalleViaje;

    /**
     * Valor referencial del servicio de transporte (campo 116, cac:DeliveryTerms con cbc:ID 01).
     *
     * @var float|null
     */
    private $valorReferencial;

    /**
     * Valor referencial sobre la carga efectiva (campo 117, cac:DeliveryTerms con cbc:ID 02).
     *
     * @var float|null
     */
    private $valorReferencialCargaEfectiva;

    /**
     * Valor referencial sobre la carga útil nominal (campo 118, cac:DeliveryTerms con cbc:ID 03).
     *
     * @var float|null
     */
    private $valorReferencialCargaUtil;

    /**
     * Los tramos del viaje (campos 119 a 128, cac:Shipment/cac:Consignment).
     *
     * @var TramoTransporte[]|null
     */
    private $tramos;

    /**
     * @return Address|null
     */
    public function getOrigen(): ?Address
    {
        return $this->origen;
    }

    /**
     * @param Address|null $origen
     *
     * @return TransporteCarga
     */
    public function setOrigen(?Address $origen): TransporteCarga
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getDestino(): ?Address
    {
        return $this->destino;
    }

    /**
     * @param Address|null $destino
     *
     * @return TransporteCarga
     */
    public function setDestino(?Address $destino): TransporteCarga
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDetalleViaje(): ?string
    {
        return $this->detalleViaje;
    }

    /**
     * @param string|null $detalleViaje
     *
     * @return TransporteCarga
     */
    public function setDetalleViaje(?string $detalleViaje): TransporteCarga
    {
        $this->detalleViaje = $detalleViaje;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorReferencial(): ?float
    {
        return $this->valorReferencial;
    }

    /**
     * @param float|null $valorReferencial
     *
     * @return TransporteCarga
     */
    public function setValorReferencial(?float $valorReferencial): TransporteCarga
    {
        $this->valorReferencial = $valorReferencial;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorReferencialCargaEfectiva(): ?float
    {
        return $this->valorReferencialCargaEfectiva;
    }

    /**
     * @param float|null $valorReferencialCargaEfectiva
     *
     * @return TransporteCarga
     */
    public function setValorReferencialCargaEfectiva(?float $valorReferencialCargaEfectiva): TransporteCarga
    {
        $this->valorReferencialCargaEfectiva = $valorReferencialCargaEfectiva;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getValorReferencialCargaUtil(): ?float
    {
        return $this->valorReferencialCargaUtil;
    }

    /**
     * @param float|null $valorReferencialCargaUtil
     *
     * @return TransporteCarga
     */
    public function setValorReferencialCargaUtil(?float $valorReferencialCargaUtil): TransporteCarga
    {
        $this->valorReferencialCargaUtil = $valorReferencialCargaUtil;

        return $this;
    }

    /**
     * @return TramoTransporte[]|null
     */
    public function getTramos(): ?array
    {
        return $this->tramos;
    }

    /**
     * @param TramoTransporte[]|null $tramos
     *
     * @return TransporteCarga
     */
    public function setTramos(?array $tramos): TransporteCarga
    {
        $this->tramos = $tramos;

        return $this;
    }
}

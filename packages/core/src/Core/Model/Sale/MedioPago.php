<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Medio de pago de la operación (cac:PaymentMeans): campos 158 y 159 de
 * «Factura2_0» y 87 y 88 de «Boleta2_0», que pide el tipo de operación 0302
 * (BVME para transporte ferroviario de pasajeros).
 */
class MedioPago
{
    /**
     * Forma de pago, catálogo 59 (cbc:PaymentMeansCode).
     *
     * @var string|null
     */
    private $codigo;

    /**
     * Número de autorización de la transacción y el sistema de la tarjeta de
     * crédito o débito, an..30 (cbc:PaymentID).
     *
     * @var string|null
     */
    private $autorizacion;

    /**
     * @return string|null
     */
    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    /**
     * @param string|null $codigo
     *
     * @return MedioPago
     */
    public function setCodigo(?string $codigo): MedioPago
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAutorizacion(): ?string
    {
        return $this->autorizacion;
    }

    /**
     * @param string|null $autorizacion
     *
     * @return MedioPago
     */
    public function setAutorizacion(?string $autorizacion): MedioPago
    {
        $this->autorizacion = $autorizacion;

        return $this;
    }
}

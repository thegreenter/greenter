<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:52 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Retention;

use DateTimeInterface;

/**
 * Class Payment.
 */
class Payment
{
    /**
     * Número de pago (cuota) asignado a la factura.
     *
     * Si no se especifica, se utiliza la posición del pago dentro del detalle.
     *
     * @var int|null
     */
    private $numero;

    /**
     * Moneda de pago (igual a la moneda del documento de referencia).
     *
     * @var string
     */
    private $moneda;

    /**
     * Importe del pago sin retención.
     *
     * @var float
     */
    private $importe;

    /**
     * Fecha de pag.
     *
     * @var DateTimeInterface
     */
    private $fecha;

    /**
     * @return int|null
     */
    public function getNumero(): ?int
    {
        return $this->numero;
    }

    /**
     * @param int|null $numero
     *
     * @return Payment
     */
    public function setNumero(?int $numero): Payment
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     *
     * @return Payment
     */
    public function setMoneda(?string $moneda): Payment
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return float
     */
    public function getImporte(): ?float
    {
        return $this->importe;
    }

    /**
     * @param float $importe
     *
     * @return Payment
     */
    public function setImporte(?float $importe): Payment
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFecha(): ?DateTimeInterface
    {
        return $this->fecha;
    }

    /**
     * @param DateTimeInterface $fecha
     *
     * @return Payment
     */
    public function setFecha(?DateTimeInterface $fecha): Payment
    {
        $this->fecha = $fecha;

        return $this;
    }
}

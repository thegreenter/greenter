<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:52 AM.
 */

namespace Greenter\Model\Retention;

/**
 * Class Payment.
 */
class Payment
{
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
     * @var \DateTime
     */
    private $fecha;

    /**
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     *
     * @return Payment
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * @param float $importe
     *
     * @return Payment
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     *
     * @return Payment
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
}

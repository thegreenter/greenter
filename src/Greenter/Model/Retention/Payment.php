<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:52 AM
 */

namespace Greenter\Model\Retention;

use Greenter\Xml\Validator\PaymentValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Payment
 * @package Greenter\Model\Retention
 */
class Payment
{
    use PaymentValidator;

    /**
     * Moneda de pago.
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="3")
     * @var string
     */
    private $moneda;

    /**
     * Importe del pago sin retención.
     *
     * @Assert\NotBlank()
     * @var float
     */
    private $importe;

    /**
     * Fecha de pag.
     *
     * @Assert\NotBlank()
     * @Assert\Date()
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
     * @return Payment
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }
}
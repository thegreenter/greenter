<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:00 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Retention;

use DateTimeInterface;

/**
 * Class Exchange.
 */
class Exchange
{
    /**
     * La moneda de referencia para el Tipo de Cambio.
     *
     * @var string
     */
    private $monedaRef;

    /**
     * La moneda objetivo para la Tasa de Cambio.
     *
     * @var string
     */
    private $monedaObj;

    /**
     * Tipo de Cambio.
     *
     * @var float
     */
    private $factor;

    /**
     * Fecha de cambio.
     *
     * @var DateTimeInterface
     */
    private $fecha;

    /**
     * @return string
     */
    public function getMonedaRef(): ?string
    {
        return $this->monedaRef;
    }

    /**
     * @param string $monedaRef
     *
     * @return Exchange
     */
    public function setMonedaRef(?string $monedaRef): Exchange
    {
        $this->monedaRef = $monedaRef;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonedaObj(): ?string
    {
        return $this->monedaObj;
    }

    /**
     * @param string $monedaObj
     *
     * @return Exchange
     */
    public function setMonedaObj(?string $monedaObj): Exchange
    {
        $this->monedaObj = $monedaObj;

        return $this;
    }

    /**
     * @return float
     */
    public function getFactor(): ?float
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     *
     * @return Exchange
     */
    public function setFactor(?float $factor): Exchange
    {
        $this->factor = $factor;

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
     * @return Exchange
     */
    public function setFecha(?DateTimeInterface $fecha): Exchange
    {
        $this->fecha = $fecha;

        return $this;
    }
}

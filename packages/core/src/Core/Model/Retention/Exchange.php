<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:00 AM.
 */

namespace Greenter\Model\Retention;

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
     * @var \DateTime
     */
    private $fecha;

    /**
     * @return string
     */
    public function getMonedaRef()
    {
        return $this->monedaRef;
    }

    /**
     * @param string $monedaRef
     *
     * @return Exchange
     */
    public function setMonedaRef($monedaRef)
    {
        $this->monedaRef = $monedaRef;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonedaObj()
    {
        return $this->monedaObj;
    }

    /**
     * @param string $monedaObj
     *
     * @return Exchange
     */
    public function setMonedaObj($monedaObj)
    {
        $this->monedaObj = $monedaObj;

        return $this;
    }

    /**
     * @return float
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     *
     * @return Exchange
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;

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
     * @return Exchange
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }
}

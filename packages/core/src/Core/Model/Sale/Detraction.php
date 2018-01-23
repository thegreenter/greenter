<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 10:00 AM
 * Se reguiere añadir leyendas al documento, dirigase al manual Datos Tributarios Recomendados - SUNAT.
 */

namespace Greenter\Model\Sale;

/**
 * Class Detraction.
 */
class Detraction
{
    /**
     * Porcentaje de la detracción.
     *
     * @var float
     */
    private $percent;

    /**
     * Monto de la detracción.
     *
     * @var float
     */
    private $mount;

    /**
     * Valor referencial, en el caso de detracciones al transporte de bienes por vía terrestre.
     *
     * @var float
     */
    private $valueRef;

    /**
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     *
     * @return Detraction
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * @return float
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * @param float $mount
     *
     * @return Detraction
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * @return float
     */
    public function getValueRef()
    {
        return $this->valueRef;
    }

    /**
     * @param float $valueRef
     *
     * @return Detraction
     */
    public function setValueRef($valueRef)
    {
        $this->valueRef = $valueRef;

        return $this;
    }
}

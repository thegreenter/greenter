<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 9/10/2018
 * Time: 12:09
 */

namespace Greenter\Model\Sale;

/**
 * Class DetailAttribute
 */
class DetailAttribute
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;
    /**
     * @var \DateTime
     */
    private $fecInicio;
    /**
     * @var \DateTime
     */
    private $fecFin;
    /**
     * @var int
     */
    private $duracion;
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
    /**
     * @param string $code
     * @return DetailAttribute
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     * @return DetailAttribute
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @param string $value
     * @return DetailAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getFecInicio()
    {
        return $this->fecInicio;
    }
    /**
     * @param \DateTime $fecInicio
     * @return DetailAttribute
     */
    public function setFecInicio($fecInicio)
    {
        $this->fecInicio = $fecInicio;
        return $this;
    }
    /**
     * @return \DateTime
     */
    public function getFecFin()
    {
        return $this->fecFin;
    }
    /**
     * @param \DateTime $fecFin
     * @return DetailAttribute
     */
    public function setFecFin($fecFin)
    {
        $this->fecFin = $fecFin;
        return $this;
    }
    /**
     * @return int
     */
    public function getDuracion()
    {
        return $this->duracion;
    }
    /**
     * Set duracion en dias.
     *
     * @param int $duracion
     * @return DetailAttribute
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
        return $this;
    }
}
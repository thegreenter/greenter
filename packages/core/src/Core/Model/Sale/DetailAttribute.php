<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 9/10/2018
 * Time: 12:09.
 */

declare(strict_types=1);

namespace Greenter\Model\Sale;

use DateTime;

/**
 * Class DetailAttribute.
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
     * @var DateTime
     */
    private $fecInicio;
    /**
     * @var DateTime
     */
    private $horaInicio;
    /**
     * @var DateTime
     */
    private $fecFin;
    /**
     * @var int
     */
    private $duracion;
    /**
     * @var float
     */
    private $cantidad;
    /**
     * @var string
     */
    private $unidad;

    /**
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return DetailAttribute
     */
    public function setCode(?string $code): DetailAttribute
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return DetailAttribute
     */
    public function setName(?string $name): DetailAttribute
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return DetailAttribute
     */
    public function setValue(?string $value): DetailAttribute
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFecInicio(): ?DateTime
    {
        return $this->fecInicio;
    }

    /**
     * @param DateTime $fecInicio
     *
     * @return DetailAttribute
     */
    public function setFecInicio(?DateTime $fecInicio): DetailAttribute
    {
        $this->fecInicio = $fecInicio;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFecFin(): ?DateTime
    {
        return $this->fecFin;
    }

    /**
     * @param DateTime $fecFin
     *
     * @return DetailAttribute
     */
    public function setFecFin(?DateTime $fecFin): DetailAttribute
    {
        $this->fecFin = $fecFin;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    /**
     * @param int $duracion
     *
     * @return DetailAttribute
     */
    public function setDuracion(?int $duracion): DetailAttribute
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Hora de inicio (cbc:StartTime), p. ej. conceptos 3060 y 4047.
     *
     * @return DateTime
     */
    public function getHoraInicio(): ?DateTime
    {
        return $this->horaInicio;
    }

    /**
     * @param DateTime $horaInicio
     *
     * @return DetailAttribute
     */
    public function setHoraInicio(?DateTime $horaInicio): DetailAttribute
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Valor numérico del concepto (cbc:ValueQuantity), p. ej. conceptos 3006 y 7019.
     *
     * @return float
     */
    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     *
     * @return DetailAttribute
     */
    public function setCantidad(?float $cantidad): DetailAttribute
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Unidad de medida de la cantidad (cbc:ValueQuantity@unitCode), p. ej. TNE.
     *
     * @return string
     */
    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    /**
     * @param string $unidad
     *
     * @return DetailAttribute
     */
    public function setUnidad(?string $unidad): DetailAttribute
    {
        $this->unidad = $unidad;

        return $this;
    }
}

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
    private $fecFin;
    /**
     * @var int
     */
    private $duracion;

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
}

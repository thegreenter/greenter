<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:56.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Class Direction.
 */
class Direction
{
    /**
     * @var string
     */
    private $ubigueo;

    /**
     * Direccion completa y detallada.
     *
     * @var string
     */
    private $direccion;

    /**
     * Código de establecimiento de punto de llegada.
     *
     * @var string
     */
    private $codLocal;
    /**
     * Número de RUC asociado al punto de llegada.
     *
     * @var string
     */
    private $ruc;
    /**
     * Latitud del punto de georreferencia, en grados decimales (cbc:LatitudeDegreesMeasure),
     * hasta 3 enteros y 8 decimales.
     *
     * Ojo: la hoja de validaciones de SUNAT rotula este tag como «Longitud» y el de
     * longitud como «Latitud»; aquí se sigue la semántica de UBL.
     *
     * @var float|null
     */
    private $latitud;
    /**
     * Longitud del punto de georreferencia, en grados decimales (cbc:LongitudeDegreesMeasure),
     * hasta 3 enteros y 8 decimales.
     *
     * @var float|null
     */
    private $longitud;
    /**
     * Direction constructor.
     *
     * @param string|null $ubigueo
     * @param string|null $direccion
     */
    public function __construct(?string $ubigueo, ?string $direccion)
    {
        $this->ubigueo = $ubigueo;
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getUbigueo(): ?string
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
     *
     * @return Direction
     */
    public function setUbigueo(?string $ubigueo): Direction
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     *
     * @return Direction
     */
    public function setDireccion(?string $direccion): Direction
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodLocal(): ?string
    {
        return $this->codLocal;
    }

    /**
     * @param string|null $codLocal
     * @return Direction
     */
    public function setCodLocal(?string $codLocal): Direction
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * @return string
     */
    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    /**
     * @param string|null $ruc
     * @return Direction
     */
    public function setRuc(?string $ruc): Direction
    {
        $this->ruc = $ruc;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitud(): ?float
    {
        return $this->latitud;
    }

    /**
     * @param float|null $latitud
     * @return Direction
     */
    public function setLatitud(?float $latitud): Direction
    {
        $this->latitud = $latitud;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitud(): ?float
    {
        return $this->longitud;
    }

    /**
     * @param float|null $longitud
     * @return Direction
     */
    public function setLongitud(?float $longitud): Direction
    {
        $this->longitud = $longitud;
        return $this;
    }
}

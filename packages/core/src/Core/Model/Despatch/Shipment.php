<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 08/08/2017
 * Time: 00:03.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

use DateTime;

/**
 * Class Shipment.
 */
class Shipment
{
    /**
     * Motivo del traslado.
     *
     * @var string
     */
    private $codTraslado;
    /**
     * Descripción de motivo de traslado.
     *
     * @var string
     */
    private $desTraslado;
    /**
     * Indicador de Transbordo Programado.
     *
     * @var bool
     */
    private $indTransbordo;
    /**
     * @var float
     */
    private $pesoTotal;
    /**
     * @var string
     */
    private $undPesoTotal;
    /**
     * Numero de Bultos.
     *
     * @var int
     */
    private $numBultos;
    /**
     * @var string
     */
    private $modTraslado;
    /**
     * Fecha de inicio del traslado.
     *
     * @var DateTime
     */
    private $fecTraslado;
    /**
     * Numero de Contenedor (Motivo Importación).
     *
     * @var string
     */
    private $numContenedor;
    /**
     * Codigo del Puerto. (Puerto o Aeropuerto de embarque/desembarque).
     *
     * @var string
     */
    private $codPuerto;
    /**
     * @var Transportist
     */
    private $transportista;
    /**
     * @var Direction
     */
    private $llegada;
    /**
     * @var Direction
     */
    private $partida;

    /**
     * @return string
     */
    public function getCodTraslado(): ?string
    {
        return $this->codTraslado;
    }

    /**
     * @param string $codTraslado
     *
     * @return Shipment
     */
    public function setCodTraslado(?string $codTraslado): Shipment
    {
        $this->codTraslado = $codTraslado;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesTraslado(): ?string
    {
        return $this->desTraslado;
    }

    /**
     * @param string $desTraslado
     *
     * @return Shipment
     */
    public function setDesTraslado(?string $desTraslado): Shipment
    {
        $this->desTraslado = $desTraslado;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIndTransbordo(): ?bool
    {
        return $this->indTransbordo;
    }

    /**
     * @param bool $indTransbordo
     *
     * @return Shipment
     */
    public function setIndTransbordo(?bool $indTransbordo): Shipment
    {
        $this->indTransbordo = $indTransbordo;

        return $this;
    }

    /**
     * @return float
     */
    public function getPesoTotal(): ?float
    {
        return $this->pesoTotal;
    }

    /**
     * @param float $pesoTotal
     *
     * @return Shipment
     */
    public function setPesoTotal(?float $pesoTotal): Shipment
    {
        $this->pesoTotal = $pesoTotal;

        return $this;
    }

    /**
     * @return string
     */
    public function getUndPesoTotal(): ?string
    {
        return $this->undPesoTotal;
    }

    /**
     * @param string $undPesoTotal
     *
     * @return Shipment
     */
    public function setUndPesoTotal(?string $undPesoTotal): Shipment
    {
        $this->undPesoTotal = $undPesoTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumBultos(): ?int
    {
        return $this->numBultos;
    }

    /**
     * @param int $numBultos
     *
     * @return Shipment
     */
    public function setNumBultos(?int $numBultos): Shipment
    {
        $this->numBultos = $numBultos;

        return $this;
    }

    /**
     * @return string
     */
    public function getModTraslado(): ?string
    {
        return $this->modTraslado;
    }

    /**
     * @param string $modTraslado
     *
     * @return Shipment
     */
    public function setModTraslado(?string $modTraslado): Shipment
    {
        $this->modTraslado = $modTraslado;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFecTraslado(): ?DateTime
    {
        return $this->fecTraslado;
    }

    /**
     * @param DateTime $fecTraslado
     *
     * @return Shipment
     */
    public function setFecTraslado(?DateTime $fecTraslado): Shipment
    {
        $this->fecTraslado = $fecTraslado;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumContenedor(): ?string
    {
        return $this->numContenedor;
    }

    /**
     * @param string $numContenedor
     *
     * @return Shipment
     */
    public function setNumContenedor(?string $numContenedor): Shipment
    {
        $this->numContenedor = $numContenedor;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodPuerto(): ?string
    {
        return $this->codPuerto;
    }

    /**
     * @param string $codPuerto
     *
     * @return Shipment
     */
    public function setCodPuerto(?string $codPuerto): Shipment
    {
        $this->codPuerto = $codPuerto;

        return $this;
    }

    /**
     * @return Transportist
     */
    public function getTransportista(): ?Transportist
    {
        return $this->transportista;
    }

    /**
     * @param Transportist $transportista
     *
     * @return Shipment
     */
    public function setTransportista(?Transportist $transportista): Shipment
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * @return Direction
     */
    public function getLlegada(): ?Direction
    {
        return $this->llegada;
    }

    /**
     * @param Direction $llegada
     *
     * @return Shipment
     */
    public function setLlegada(?Direction $llegada): Shipment
    {
        $this->llegada = $llegada;

        return $this;
    }

    /**
     * @return Direction
     */
    public function getPartida(): ?Direction
    {
        return $this->partida;
    }

    /**
     * @param Direction $partida
     *
     * @return Shipment
     */
    public function setPartida(?Direction $partida): Shipment
    {
        $this->partida = $partida;

        return $this;
    }
}

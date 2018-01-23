<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 08/08/2017
 * Time: 00:03.
 */

namespace Greenter\Model\Despatch;

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
     * @var \DateTime
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
    public function getCodTraslado()
    {
        return $this->codTraslado;
    }

    /**
     * @param string $codTraslado
     *
     * @return Shipment
     */
    public function setCodTraslado($codTraslado)
    {
        $this->codTraslado = $codTraslado;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesTraslado()
    {
        return $this->desTraslado;
    }

    /**
     * @param string $desTraslado
     *
     * @return Shipment
     */
    public function setDesTraslado($desTraslado)
    {
        $this->desTraslado = $desTraslado;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIndTransbordo()
    {
        return $this->indTransbordo;
    }

    /**
     * @param bool $indTransbordo
     *
     * @return Shipment
     */
    public function setIndTransbordo($indTransbordo)
    {
        $this->indTransbordo = $indTransbordo;

        return $this;
    }

    /**
     * @return float
     */
    public function getPesoTotal()
    {
        return $this->pesoTotal;
    }

    /**
     * @param float $pesoTotal
     *
     * @return Shipment
     */
    public function setPesoTotal($pesoTotal)
    {
        $this->pesoTotal = $pesoTotal;

        return $this;
    }

    /**
     * @return string
     */
    public function getUndPesoTotal()
    {
        return $this->undPesoTotal;
    }

    /**
     * @param string $undPesoTotal
     *
     * @return Shipment
     */
    public function setUndPesoTotal($undPesoTotal)
    {
        $this->undPesoTotal = $undPesoTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumBultos()
    {
        return $this->numBultos;
    }

    /**
     * @param int $numBultos
     *
     * @return Shipment
     */
    public function setNumBultos($numBultos)
    {
        $this->numBultos = $numBultos;

        return $this;
    }

    /**
     * @return string
     */
    public function getModTraslado()
    {
        return $this->modTraslado;
    }

    /**
     * @param string $modTraslado
     *
     * @return Shipment
     */
    public function setModTraslado($modTraslado)
    {
        $this->modTraslado = $modTraslado;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecTraslado()
    {
        return $this->fecTraslado;
    }

    /**
     * @param \DateTime $fecTraslado
     *
     * @return Shipment
     */
    public function setFecTraslado($fecTraslado)
    {
        $this->fecTraslado = $fecTraslado;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumContenedor()
    {
        return $this->numContenedor;
    }

    /**
     * @param string $numContenedor
     *
     * @return Shipment
     */
    public function setNumContenedor($numContenedor)
    {
        $this->numContenedor = $numContenedor;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodPuerto()
    {
        return $this->codPuerto;
    }

    /**
     * @param string $codPuerto
     *
     * @return Shipment
     */
    public function setCodPuerto($codPuerto)
    {
        $this->codPuerto = $codPuerto;

        return $this;
    }

    /**
     * @return Transportist
     */
    public function getTransportista()
    {
        return $this->transportista;
    }

    /**
     * @param Transportist $transportista
     *
     * @return Shipment
     */
    public function setTransportista($transportista)
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * @return Direction
     */
    public function getLlegada()
    {
        return $this->llegada;
    }

    /**
     * @param Direction $llegada
     *
     * @return Shipment
     */
    public function setLlegada($llegada)
    {
        $this->llegada = $llegada;

        return $this;
    }

    /**
     * @return Direction
     */
    public function getPartida()
    {
        return $this->partida;
    }

    /**
     * @param Direction $partida
     *
     * @return Shipment
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;

        return $this;
    }
}

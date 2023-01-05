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
     * Sustento de la diferencia del Peso bruto total de la carga respecto al peso de los ítems seleccionados.
     *
     * @var string
     */
    private $sustentoPeso;
    /**
     * Indicador de Transbordo Programado.
     *
     * @var bool
     */
    private $indTransbordo;
    /**
     * Indicador de traslado, Retorno, Transbordo, etc.
     * opciones:
     *
     * SUNAT_Envio_IndicadorTransbordoProgramado
     * SUNAT_Envio_IndicadorTrasladoVehiculoM1L
     * SUNAT_Envio_IndicadorRetornoVehiculoEnvaseVacio
     * SUNAT_Envio_IndicadorRetornoVehiculoVacio
     * SUNAT_Envio_IndicadorTrasladoTotalDAMoDS
     * SUNAT_Envio_IndicadorVehiculoConductoresTransp
     *
     * @var string[]
     */
    private $indicadores;
    /**
     * Peso bruto total de los ítems seleccionados (en KGM).
     *
     * @var float
     */
    private $pesoItems;
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
     * Contenedores (precinto)
     *
     * @var string[]
     */
    private $contenedores;
    /**
     * Codigo del Puerto. (Puerto o Aeropuerto de embarque/desembarque).
     *
     * @var string
     */
    private $codPuerto;
    /**
     * @var Puerto
     */
    private $puerto;
    /**
     * @var Puerto
     */
    private $aeropuerto;
    /**
     * @var Transportist
     */
    private $transportista;
    /**
     * Vehiculo Principal.
     *
     * @var Vehicle
     */
    private $vehiculo;
    /**
     * Conductores principales y secundarios.
     *
     * @var Driver[]
     */
    private $choferes;
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
     * @return string
     */
    public function getSustentoPeso(): ?string
    {
        return $this->sustentoPeso;
    }

    /**
     * @param string|null $sustentoPeso
     * @return Shipment
     */
    public function setSustentoPeso(?string $sustentoPeso): Shipment
    {
        $this->sustentoPeso = $sustentoPeso;
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
     * @deprecated use setIndicadores
     *
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
     * @return string[]
     */
    public function getIndicadores(): ?array
    {
        return $this->indicadores;
    }

    /**
     * @param string[] $indicadores
     * @return Shipment
     */
    public function setIndicadores(?array $indicadores): Shipment
    {
        $this->indicadores = $indicadores;
        return $this;
    }

    /**
     * @return float
     */
    public function getPesoItems(): ?float
    {
        return $this->pesoItems;
    }

    /**
     * @param float|null $pesoItems
     * @return Shipment
     */
    public function setPesoItems(?float $pesoItems): Shipment
    {
        $this->pesoItems = $pesoItems;
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
     * @deprecated use setContenedores
     *
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
     * @return string[]
     */
    public function getContenedores(): ?array
    {
        return $this->contenedores;
    }

    /**
     * @param string[] $contenedores
     * @return Shipment
     */
    public function setContenedores(?array $contenedores): Shipment
    {
        $this->contenedores = $contenedores;
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
     * @deprecated use setPuerto
     *
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
     * @return Puerto
     */
    public function getPuerto(): ?Puerto
    {
        return $this->puerto;
    }

    /**
     * @param Puerto|null $puerto
     * @return Shipment
     */
    public function setPuerto(?Puerto $puerto): Shipment
    {
        $this->puerto = $puerto;
        return $this;
    }

    /**
     * @return Puerto
     */
    public function getAeropuerto(): ?Puerto
    {
        return $this->aeropuerto;
    }

    /**
     * @param Puerto|null $aeropuerto
     * @return Shipment
     */
    public function setAeropuerto(?Puerto $aeropuerto): Shipment
    {
        $this->aeropuerto = $aeropuerto;
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
     * @return Vehicle
     */
    public function getVehiculo(): ?Vehicle
    {
        return $this->vehiculo;
    }

    /**
     * @param Vehicle|null $vehiculo
     * @return Shipment
     */
    public function setVehiculo(?Vehicle $vehiculo): Shipment
    {
        $this->vehiculo = $vehiculo;
        return $this;
    }

    /**
     * @return Driver[]
     */
    public function getChoferes(): ?array
    {
        return $this->choferes;
    }

    /**
     * @param Driver[] $choferes
     * @return Shipment
     */
    public function setChoferes(?array $choferes): Shipment
    {
        $this->choferes = $choferes;
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

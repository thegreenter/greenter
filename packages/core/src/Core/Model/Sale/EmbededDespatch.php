<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 05:19 PM.
 */

namespace Greenter\Model\Sale;

use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Direction;

/**
 * Class EmbededDespatch.
 */
class EmbededDespatch
{
    /**
     * @var Direction
     */
    private $llegada;

    /**
     * @var Direction
     */
    private $partida;

    /**
     * @var Client
     */
    private $transportista;

    /**
     * N° de licencia de conducir.
     *
     * @var string
     */
    private $nroLicencia;

    /**
     * @var string
     */
    private $transpPlaca;

    /**
     * @var string
     */
    private $transpCodeAuth;

    /**
     * @var string
     */
    private $transpMarca;

    /**
     * @var string
     */
    private $modTraslado;

    /**
     * @var float
     */
    private $pesoBruto;

    /**
     * @var string
     */
    private $undPesoBruto;

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
     * @return EmbededDespatch
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
     * @return EmbededDespatch
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * @return Client
     */
    public function getTransportista()
    {
        return $this->transportista;
    }

    /**
     * @param Client $transportista
     *
     * @return EmbededDespatch
     */
    public function setTransportista($transportista)
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroLicencia()
    {
        return $this->nroLicencia;
    }

    /**
     * @param string $nroLicencia
     *
     * @return EmbededDespatch
     */
    public function setNroLicencia($nroLicencia)
    {
        $this->nroLicencia = $nroLicencia;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspPlaca()
    {
        return $this->transpPlaca;
    }

    /**
     * @param string $transpPlaca
     *
     * @return EmbededDespatch
     */
    public function setTranspPlaca($transpPlaca)
    {
        $this->transpPlaca = $transpPlaca;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspCodeAuth()
    {
        return $this->transpCodeAuth;
    }

    /**
     * @param string $transpCodeAuth
     *
     * @return EmbededDespatch
     */
    public function setTranspCodeAuth($transpCodeAuth)
    {
        $this->transpCodeAuth = $transpCodeAuth;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspMarca()
    {
        return $this->transpMarca;
    }

    /**
     * @param string $transpMarca
     *
     * @return EmbededDespatch
     */
    public function setTranspMarca($transpMarca)
    {
        $this->transpMarca = $transpMarca;

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
     * @return EmbededDespatch
     */
    public function setModTraslado($modTraslado)
    {
        $this->modTraslado = $modTraslado;

        return $this;
    }

    /**
     * @return float
     */
    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    /**
     * @param float $pesoBruto
     *
     * @return EmbededDespatch
     */
    public function setPesoBruto($pesoBruto)
    {
        $this->pesoBruto = $pesoBruto;

        return $this;
    }

    /**
     * @return string
     */
    public function getUndPesoBruto()
    {
        return $this->undPesoBruto;
    }

    /**
     * @param string $undPesoBruto
     *
     * @return EmbededDespatch
     */
    public function setUndPesoBruto($undPesoBruto)
    {
        $this->undPesoBruto = $undPesoBruto;

        return $this;
    }
}

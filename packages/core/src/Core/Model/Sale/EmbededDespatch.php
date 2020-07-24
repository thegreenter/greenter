<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 05:19 PM.
 */

declare(strict_types=1);

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
    public function getLlegada(): ?Direction
    {
        return $this->llegada;
    }

    /**
     * @param Direction $llegada
     *
     * @return EmbededDespatch
     */
    public function setLlegada(?Direction $llegada): EmbededDespatch
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
     * @return EmbededDespatch
     */
    public function setPartida(?Direction $partida): EmbededDespatch
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * @return Client
     */
    public function getTransportista(): ?Client
    {
        return $this->transportista;
    }

    /**
     * @param Client $transportista
     *
     * @return EmbededDespatch
     */
    public function setTransportista(?Client $transportista): EmbededDespatch
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroLicencia(): ?string
    {
        return $this->nroLicencia;
    }

    /**
     * @param string $nroLicencia
     *
     * @return EmbededDespatch
     */
    public function setNroLicencia(?string $nroLicencia): EmbededDespatch
    {
        $this->nroLicencia = $nroLicencia;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspPlaca(): ?string
    {
        return $this->transpPlaca;
    }

    /**
     * @param string $transpPlaca
     *
     * @return EmbededDespatch
     */
    public function setTranspPlaca(?string $transpPlaca): EmbededDespatch
    {
        $this->transpPlaca = $transpPlaca;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspCodeAuth(): ?string
    {
        return $this->transpCodeAuth;
    }

    /**
     * @param string $transpCodeAuth
     *
     * @return EmbededDespatch
     */
    public function setTranspCodeAuth(?string $transpCodeAuth): EmbededDespatch
    {
        $this->transpCodeAuth = $transpCodeAuth;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranspMarca(): ?string
    {
        return $this->transpMarca;
    }

    /**
     * @param string $transpMarca
     *
     * @return EmbededDespatch
     */
    public function setTranspMarca(?string $transpMarca): EmbededDespatch
    {
        $this->transpMarca = $transpMarca;

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
     * @return EmbededDespatch
     */
    public function setModTraslado(?string $modTraslado): EmbededDespatch
    {
        $this->modTraslado = $modTraslado;

        return $this;
    }

    /**
     * @return float
     */
    public function getPesoBruto(): ?float
    {
        return $this->pesoBruto;
    }

    /**
     * @param float $pesoBruto
     *
     * @return EmbededDespatch
     */
    public function setPesoBruto(?float $pesoBruto): EmbededDespatch
    {
        $this->pesoBruto = $pesoBruto;

        return $this;
    }

    /**
     * @return string
     */
    public function getUndPesoBruto(): ?string
    {
        return $this->undPesoBruto;
    }

    /**
     * @param string $undPesoBruto
     *
     * @return EmbededDespatch
     */
    public function setUndPesoBruto(?string $undPesoBruto): EmbededDespatch
    {
        $this->undPesoBruto = $undPesoBruto;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:39.
 */

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Class Transportist.
 */
class Transportist
{
    /**
     * @var string
     */
    private $tipoDoc;
    /**
     * @var string
     */
    private $numDoc;
    /**
     * @var string
     */
    private $rznSocial;
    /**
     * Número de Registro MTC.
     *
     * @var string
     */
    private $nroMtc;
    /**
     * (Transporte Privado).
     *
     * @var string
     */
    private $placa;
    /**
     * (Transporte Privado).
     *
     * @var string
     */
    private $choferTipoDoc;
    /**
     * (Transporte Privado).
     *
     * @var string
     */
    private $choferDoc;

    /**
     * @return string
     */
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return Transportist
     */
    public function setTipoDoc(?string $tipoDoc): Transportist
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc(): ?string
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     *
     * @return Transportist
     */
    public function setNumDoc(?string $numDoc): Transportist
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getRznSocial(): ?string
    {
        return $this->rznSocial;
    }

    /**
     * @param string $rznSocial
     *
     * @return Transportist
     */
    public function setRznSocial(?string $rznSocial): Transportist
    {
        $this->rznSocial = $rznSocial;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroMtc(): ?string
    {
        return $this->nroMtc;
    }

    /**
     * @param string|null $nroMtc
     * @return Transportist
     */
    public function setNroMtc(?string $nroMtc): Transportist
    {
        $this->nroMtc = $nroMtc;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaca(): ?string
    {
        return $this->placa;
    }

    /**
     * @deprecated use shipment.vehicles
     *
     * @param string $placa
     *
     * @return Transportist
     */
    public function setPlaca(?string $placa): Transportist
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * @return string
     */
    public function getChoferTipoDoc(): ?string
    {
        return $this->choferTipoDoc;
    }

    /**
     * @deprecated use shipment.drivers
     *
     * @param string $choferTipoDoc
     *
     * @return Transportist
     */
    public function setChoferTipoDoc(?string $choferTipoDoc): Transportist
    {
        $this->choferTipoDoc = $choferTipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getChoferDoc(): ?string
    {
        return $this->choferDoc;
    }

    /**
     * @deprecated use shipment.drivers
     *
     * @param string $choferDoc
     *
     * @return Transportist
     */
    public function setChoferDoc(?string $choferDoc): Transportist
    {
        $this->choferDoc = $choferDoc;

        return $this;
    }
}

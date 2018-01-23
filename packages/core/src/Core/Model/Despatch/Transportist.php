<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:39.
 */

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
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return Transportist
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc()
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     *
     * @return Transportist
     */
    public function setNumDoc($numDoc)
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getRznSocial()
    {
        return $this->rznSocial;
    }

    /**
     * @param string $rznSocial
     *
     * @return Transportist
     */
    public function setRznSocial($rznSocial)
    {
        $this->rznSocial = $rznSocial;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * @param string $placa
     *
     * @return Transportist
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * @return string
     */
    public function getChoferTipoDoc()
    {
        return $this->choferTipoDoc;
    }

    /**
     * @param string $choferTipoDoc
     *
     * @return Transportist
     */
    public function setChoferTipoDoc($choferTipoDoc)
    {
        $this->choferTipoDoc = $choferTipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getChoferDoc()
    {
        return $this->choferDoc;
    }

    /**
     * @param string $choferDoc
     *
     * @return Transportist
     */
    public function setChoferDoc($choferDoc)
    {
        $this->choferDoc = $choferDoc;

        return $this;
    }
}

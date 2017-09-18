<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:01
 */

namespace Greenter\Report\Model;

/**
 * Class Client
 * @package Greenter\Report\Model
 */
class Client
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
     * @var string
     */
    private $direccion;

    /**
     * @return mixed
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param mixed $tipoDoc
     * @return Client
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumDoc()
    {
        return $this->numDoc;
    }

    /**
     * @param mixed $numDoc
     * @return Client
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
     * @return Client
     */
    public function setRznSocial($rznSocial)
    {
        $this->rznSocial = $rznSocial;
        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     * @return Client
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }
}
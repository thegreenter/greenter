<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00
 */

namespace Greenter\Xml\Model\Voided;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class VoidedDetail
 * @package Greenter\Xml\Model\Voided
 */
class VoidedDetail
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="2")
     * @var string
     */
    private $tipoDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="4")
     * @var string
     */
    private $serie;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="8")
     * @var string
     */
    private $correlativo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    private $desMotivoBaja;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return VoidedDetail
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     * @return VoidedDetail
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * @return string
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     * @return VoidedDetail
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesMotivoBaja()
    {
        return $this->desMotivoBaja;
    }

    /**
     * @param string $desMotivoBaja
     * @return VoidedDetail
     */
    public function setDesMotivoBaja($desMotivoBaja)
    {
        $this->desMotivoBaja = $desMotivoBaja;
        return $this;
    }
}
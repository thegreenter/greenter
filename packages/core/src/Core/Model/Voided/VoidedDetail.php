<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00.
 */

namespace Greenter\Model\Voided;

/**
 * Class VoidedDetail.
 */
class VoidedDetail
{
    /**
     * @var string
     */
    private $tipoDoc;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $correlativo;

    /**
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
     *
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
     *
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
     *
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
     *
     * @return VoidedDetail
     */
    public function setDesMotivoBaja($desMotivoBaja)
    {
        $this->desMotivoBaja = $desMotivoBaja;

        return $this;
    }
}

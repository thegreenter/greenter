<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00.
 */

declare(strict_types=1);

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
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return VoidedDetail
     */
    public function setTipoDoc(?string $tipoDoc): VoidedDetail
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     *
     * @return VoidedDetail
     */
    public function setSerie(?string $serie): VoidedDetail
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorrelativo(): ?string
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return VoidedDetail
     */
    public function setCorrelativo(?string $correlativo): VoidedDetail
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * @return string
     */
    public function getDesMotivoBaja(): ?string
    {
        return $this->desMotivoBaja;
    }

    /**
     * @param string $desMotivoBaja
     *
     * @return VoidedDetail
     */
    public function setDesMotivoBaja(?string $desMotivoBaja): VoidedDetail
    {
        $this->desMotivoBaja = $desMotivoBaja;

        return $this;
    }
}

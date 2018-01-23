<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/09/2017
 * Time: 08:21 PM.
 */

namespace Greenter\Model\Sale;

/**
 * Class Prepayment.
 */
class Prepayment
{
    /**
     * @var string
     */
    private $tipoDocRel;

    /**
     * @var string
     */
    private $nroDocRel;

    /**
     * @var float
     */
    private $total;

    /**
     * @return string
     */
    public function getTipoDocRel()
    {
        return $this->tipoDocRel;
    }

    /**
     * @param string $tipoDocRel
     *
     * @return Prepayment
     */
    public function setTipoDocRel($tipoDocRel)
    {
        $this->tipoDocRel = $tipoDocRel;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroDocRel()
    {
        return $this->nroDocRel;
    }

    /**
     * @param string $nroDocRel
     *
     * @return Prepayment
     */
    public function setNroDocRel($nroDocRel)
    {
        $this->nroDocRel = $nroDocRel;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     *
     * @return Prepayment
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }
}

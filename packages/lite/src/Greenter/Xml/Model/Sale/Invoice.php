<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:05
 */

namespace Greenter\Xml\Model\Sale;

use Greenter\Xml\Validator\InvoiceValidator;

/**
 * Class Invoice
 * @package Greenter\Xml\Model\Sale
 */
class Invoice extends BaseSale
{
    use InvoiceValidator;

    /**
     * Tipo operacion (Catálogo 17).
     * @var string
     */
    private $tipoOperacion;

    /**
     * @var float
     */
    private $mtoOperGratuitas;

    /**
     * @var float
     */
    private $sumDsctoGlobal;

    /**
     * @var float
     */
    private $mtoDescuentos;

    /**
     * @var string
     */
    private $codRegPercepcion;

    /**
     * @var float
     */
    private $mtoBasePercepcion;

    /**
     * @var float
     */
    private $mtoPercepcion;

    /**
     * @var float
     */
    private $mtoTotalPercepcion;

    /**
     * @return string
     */
    public function getTipoOperacion()
    {
        return $this->tipoOperacion;
    }

    /**
     * @param string $tipoOperacion
     * @return Invoice
     */
    public function setTipoOperacion($tipoOperacion)
    {
        $this->tipoOperacion = $tipoOperacion;
        return $this;
    }

    /**
     * @return float
     */
    public function getSumDsctoGlobal()
    {
        return $this->sumDsctoGlobal;
    }

    /**
     * @param float $sumDsctoGlobal
     * @return Invoice
     */
    public function setSumDsctoGlobal($sumDsctoGlobal)
    {
        $this->sumDsctoGlobal = $sumDsctoGlobal;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoDescuentos()
    {
        return $this->mtoDescuentos;
    }

    /**
     * @param float $mtoDescuentos
     * @return Invoice
     */
    public function setMtoDescuentos($mtoDescuentos)
    {
        $this->mtoDescuentos = $mtoDescuentos;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoOperGratuitas()
    {
        return $this->mtoOperGratuitas;
    }

    /**
     * @param float $mtoOperGratuitas
     * @return Invoice
     */
    public function setMtoOperGratuitas($mtoOperGratuitas)
    {
        $this->mtoOperGratuitas = $mtoOperGratuitas;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodRegPercepcion()
    {
        return $this->codRegPercepcion;
    }

    /**
     * @param string $codRegPercepcion
     * @return Invoice
     */
    public function setCodRegPercepcion($codRegPercepcion)
    {
        $this->codRegPercepcion = $codRegPercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoBasePercepcion()
    {
        return $this->mtoBasePercepcion;
    }

    /**
     * @param float $mtoBasePercepcion
     * @return Invoice
     */
    public function setMtoBasePercepcion($mtoBasePercepcion)
    {
        $this->mtoBasePercepcion = $mtoBasePercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoPercepcion()
    {
        return $this->mtoPercepcion;
    }

    /**
     * @param float $mtoPercepcion
     * @return Invoice
     */
    public function setMtoPercepcion($mtoPercepcion)
    {
        $this->mtoPercepcion = $mtoPercepcion;
        return $this;
    }

    /**
     * @return float
     */
    public function getMtoTotalPercepcion()
    {
        return $this->mtoTotalPercepcion;
    }

    /**
     * @param float $mtoTotalPercepcion
     * @return Invoice
     */
    public function setMtoTotalPercepcion($mtoTotalPercepcion)
    {
        $this->mtoTotalPercepcion = $mtoTotalPercepcion;
        return $this;
    }
}
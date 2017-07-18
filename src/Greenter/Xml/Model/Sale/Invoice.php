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
    private $mtoBaseImponiblePercepcion;

    /**
     * @var float
     */
    private $mtoPercepcion;

    /**
     * @var float
     */
    private $mtoTotalIncPercepcion;

    private $TipoDocGuia;

    private $NumDocGuia;

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
    public function getMtoBaseImponiblePercepcion()
    {
        return $this->mtoBaseImponiblePercepcion;
    }

    /**
     * @param float $mtoBaseImponiblePercepcion
     * @return Invoice
     */
    public function setMtoBaseImponiblePercepcion($mtoBaseImponiblePercepcion)
    {
        $this->mtoBaseImponiblePercepcion = $mtoBaseImponiblePercepcion;
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
    public function getMtoTotalIncPercepcion()
    {
        return $this->mtoTotalIncPercepcion;
    }

    /**
     * @param float $mtoTotalIncPercepcion
     * @return Invoice
     */
    public function setMtoTotalIncPercepcion($mtoTotalIncPercepcion)
    {
        $this->mtoTotalIncPercepcion = $mtoTotalIncPercepcion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoDocGuia()
    {
        return $this->TipoDocGuia;
    }

    /**
     * @param mixed $TipoDocGuia
     * @return Invoice
     */
    public function setTipoDocGuia($TipoDocGuia)
    {
        $this->TipoDocGuia = $TipoDocGuia;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumDocGuia()
    {
        return $this->NumDocGuia;
    }

    /**
     * @param mixed $NumDocGuia
     * @return Invoice
     */
    public function setNumDocGuia($NumDocGuia)
    {
        $this->NumDocGuia = $NumDocGuia;
        return $this;
    }

}
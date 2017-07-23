<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:51
 */

namespace Greenter\Model\Sale;

use Greenter\Xml\Validator\NoteValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Note
 * @package Greenter\Model\Sale
 */
class Note extends BaseSale
{
    use NoteValidator;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $codMotivo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="250")
     * @var string
     */
    private $desMotivo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="2")
     * @var string
     */
    private $tipDocAfectado;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="13")
     * @var string
     */
    private $numDocfectado;

    /**
     * @var float
     */
    private $mtoOperGratuitas;

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
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * @param string $codMotivo
     * @return Note
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesMotivo()
    {
        return $this->desMotivo;
    }

    /**
     * @param string $desMotivo
     * @return Note
     */
    public function setDesMotivo($desMotivo)
    {
        $this->desMotivo = $desMotivo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipDocAfectado()
    {
        return $this->tipDocAfectado;
    }

    /**
     * @param string $tipDocAfectado
     * @return Note
     */
    public function setTipDocAfectado($tipDocAfectado)
    {
        $this->tipDocAfectado = $tipDocAfectado;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumDocfectado()
    {
        return $this->numDocfectado;
    }

    /**
     * @param string $numDocfectado
     * @return Note
     */
    public function setNumDocfectado($numDocfectado)
    {
        $this->numDocfectado = $numDocfectado;
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
     * @return Note
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
     * @return Note
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
     * @return Note
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
     * @return Note
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
     * @return Note
     */
    public function setMtoTotalPercepcion($mtoTotalPercepcion)
    {
        $this->mtoTotalPercepcion = $mtoTotalPercepcion;
        return $this;
    }
}
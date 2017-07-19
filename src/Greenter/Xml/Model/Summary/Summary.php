<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:59
 */

namespace Greenter\Xml\Model\Summary;

use Greenter\Xml\Validator\SummaryValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Summary
 * @package Greenter\Xml\Model\Summary
 */
class Summary
{
    use SummaryValidator;

    /**
     * @Assert\Length(max="3")
     * @var string
     */
    private $correlativo;
    /**
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecGeneracion;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecResumen;

    /**
     * @Assert\Valid()
     * @var SummaryDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     * @return Summary
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecGeneracion()
    {
        return $this->fecGeneracion;
    }

    /**
     * @param \DateTime $fecGeneracion
     * @return Summary
     */
    public function setFecGeneracion($fecGeneracion)
    {
        $this->fecGeneracion = $fecGeneracion;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecResumen()
    {
        return $this->fecResumen;
    }

    /**
     * @param \DateTime $fecResumen
     * @return Summary
     */
    public function setFecResumen($fecResumen)
    {
        $this->fecResumen = $fecResumen;
        return $this;
    }

    /**
     * @return SummaryDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param SummaryDetail[] $details
     * @return Summary
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }
}
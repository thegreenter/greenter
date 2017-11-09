<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00
 */

namespace Greenter\Model\Voided;

use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Voided
 * @package Greenter\Model\Voided
 */
class Voided implements DocumentInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="5")
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación del documento dado de baja.
     *
     * @Assert\Date()
     * @var \DateTime
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación de la comunicación.
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime
     */
    protected $fecComunicacion;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Company
     */
    protected $company;

    /**
     * @Assert\Valid()
     * @var VoidedDetail[]
     */
    protected $details;

    public function __construct()
    {
        $this->fecGeneracion = new \DateTime();
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
     * @return Voided
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
     * @return Voided
     */
    public function setFecGeneracion($fecGeneracion)
    {
        $this->fecGeneracion = $fecGeneracion;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFecComunicacion()
    {
        return $this->fecComunicacion;
    }

    /**
     * @param \DateTime $fecComunicacion
     * @return Voided
     */
    public function setFecComunicacion($fecComunicacion)
    {
        $this->fecComunicacion = $fecComunicacion;
        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     * @return Voided
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return VoidedDetail[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param VoidedDetail[] $details
     * @return Voided
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName()
    {
        return $this->company->getRuc() . '-' . $this->getXmlId();
    }

    /**
     * Get Id XML.
     *
     * @return string
     */
    public function getXmlId()
    {
        $parts = [
            'RA',
            $this->getFecComunicacion()->format('Ymd'),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
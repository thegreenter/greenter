<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:08 PM
 */

namespace Greenter\Model\Summary;

use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Xml\Validator\SummaryValidator;

/**
 * Class SummaryV2
 * @package Greenter\Model\Summary
 */
class SummaryV2 implements DocumentInterface
{
    use SummaryValidator;

    /**
     * @Assert\Length(max="3")
     * @var string
     */
    private $correlativo;

    /**
     * Fecha de generación de los documentos a enviar en el resumen.
     *
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecGeneracion;

    /**
     * Fecha de generación del resumen.
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecResumen;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @var Company
     */
    private $company;

    /**
     * @Assert\Valid()
     * @var SummaryDetailV2[]
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
     * @return SummaryV2
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
     * @return SummaryV2
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
     * @return SummaryV2
     */
    public function setFecResumen($fecResumen)
    {
        $this->fecResumen = $fecResumen;
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
     * @return SummaryV2
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return SummaryDetailV2[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param SummaryDetailV2[] $details
     * @return SummaryV2
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
        $parts = [
            $this->company->getRuc(),
            'RC',
            $this->getFecResumen()->format('Ymd'),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
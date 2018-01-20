<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:59.
 */

namespace Greenter\Model\Summary;

use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Summary.
 */
class Summary implements DocumentInterface
{
    /**
     * @Assert\Length(max="5")
     *
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación de los documentos a enviar en el resumen.
     *
     * @Assert\Date()
     *
     * @var \DateTime
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación del resumen.
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     *
     * @var \DateTime
     */
    protected $fecResumen;

    /**
     * @Assert\NotBlank()
     * @Assert\Valid()
     *
     * @var Company
     */
    protected $company;

    /**
     * @Assert\Valid()
     *
     * @var SummaryDetail[]
     */
    protected $details;

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
     *
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
     *
     * @return Summary
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
     *
     * @return Summary
     */
    public function setCompany($company)
    {
        $this->company = $company;

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
     *
     * @return Summary
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

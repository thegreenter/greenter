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
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación de los documentos a enviar en el resumen.
     *
     * @var \DateTimeInterface
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación del resumen.
     *
     * @var \DateTimeInterface
     */
    protected $fecResumen;

    /**
     * @var string
     */
    protected $moneda = 'PEN';

    /**
     * @var Company
     */
    protected $company;

    /**
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
     * @return \DateTimeInterface
     */
    public function getFecGeneracion()
    {
        return $this->fecGeneracion;
    }

    /**
     * @param \DateTimeInterface $fecGeneracion
     *
     * @return Summary
     */
    public function setFecGeneracion(\DateTimeInterface $fecGeneracion)
    {
        $this->fecGeneracion = $fecGeneracion;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFecResumen()
    {
        return $this->fecResumen;
    }

    /**
     * @param \DateTimeInterface $fecResumen
     *
     * @return Summary
     */
    public function setFecResumen(\DateTimeInterface $fecResumen)
    {
        $this->fecResumen = $fecResumen;

        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     * @return Summary
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
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
    public function setCompany(Company $company)
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
     * Get Id XML.
     *
     * @return string
     */
    public function getXmlId()
    {
        $parts = [
            'RC',
            $this->getFecResumen()->format('Ymd'),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName()
    {
        return $this->company->getRuc().'-'.$this->getXmlId();
    }
}

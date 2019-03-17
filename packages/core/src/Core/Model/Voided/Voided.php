<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00.
 */

namespace Greenter\Model\Voided;

use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Voided.
 */
class Voided implements DocumentInterface
{
    /**
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación de los documentos a dar baja.
     *
     * @var \DateTimeInterface
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación de la comunicación.
     *
     * @var \DateTimeInterface
     */
    protected $fecComunicacion;

    /**
     * @var Company
     */
    protected $company;

    /**
     * @var VoidedDetail[]
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
     * @return $this
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
     * @return $this
     */
    public function setFecGeneracion(\DateTimeInterface $fecGeneracion)
    {
        $this->fecGeneracion = $fecGeneracion;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFecComunicacion()
    {
        return $this->fecComunicacion;
    }

    /**
     * @param \DateTimeInterface $fecComunicacion
     *
     * @return $this
     */
    public function setFecComunicacion(\DateTimeInterface $fecComunicacion)
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
     *
     * @return $this
     */
    public function setCompany(Company $company)
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
     *
     * @return $this
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
            'RA',
            $this->getFecComunicacion()->format('Ymd'),
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

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00.
 */

declare(strict_types=1);

namespace Greenter\Model\Voided;

use DateTimeInterface;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Model\TimezonePeTrait;

/**
 * Class Voided.
 */
class Voided implements DocumentInterface
{
    use TimezonePeTrait;

    /**
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación de los documentos a dar baja.
     *
     * @var DateTimeInterface
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación de la comunicación.
     *
     * @var DateTimeInterface
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
    public function getCorrelativo(): ?string
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return $this
     */
    public function setCorrelativo(?string $correlativo): Voided
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFecGeneracion(): ?DateTimeInterface
    {
        return $this->fecGeneracion;
    }

    /**
     * @param DateTimeInterface $fecGeneracion
     *
     * @return $this
     */
    public function setFecGeneracion(?DateTimeInterface $fecGeneracion): Voided
    {
        $this->fecGeneracion = $fecGeneracion;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFecComunicacion(): ?DateTimeInterface
    {
        return $this->fecComunicacion;
    }

    /**
     * @param DateTimeInterface $fecComunicacion
     *
     * @return $this
     */
    public function setFecComunicacion(?DateTimeInterface $fecComunicacion): Voided
    {
        $this->fecComunicacion = $fecComunicacion;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     *
     * @return $this
     */
    public function setCompany(?Company $company): Voided
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return VoidedDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param VoidedDetail[] $details
     *
     * @return $this
     */
    public function setDetails(?array $details): Voided
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get Id XML.
     *
     * @return string
     */
    public function getXmlId(): string
    {
        $fecComunicacionPe = $this->getDateWithTimezone($this->fecComunicacion);
        $parts = [
            'RA',
            $fecComunicacionPe->format('Ymd'),
            $this->correlativo,
        ];

        return join('-', $parts);
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->company->getRuc().'-'.$this->getXmlId();
    }
}

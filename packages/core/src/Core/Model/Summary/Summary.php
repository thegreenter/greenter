<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 21:59.
 */

declare(strict_types=1);

namespace Greenter\Model\Summary;

use DateTimeInterface;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Model\TimezonePeTrait;

/**
 * Class Summary.
 */
class Summary implements DocumentInterface
{
    use TimezonePeTrait;

    /**
     * @var string
     */
    protected $correlativo;

    /**
     * Fecha de generación de los documentos a enviar en el resumen.
     *
     * @var DateTimeInterface
     */
    protected $fecGeneracion;

    /**
     * Fecha de generación del resumen.
     *
     * @var DateTimeInterface
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
    public function getCorrelativo(): ?string
    {
        return $this->correlativo;
    }

    /**
     * @param string $correlativo
     *
     * @return Summary
     */
    public function setCorrelativo(?string $correlativo): Summary
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
     * @return Summary
     */
    public function setFecGeneracion(?DateTimeInterface $fecGeneracion): Summary
    {
        $this->fecGeneracion = $fecGeneracion;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFecResumen(): ?DateTimeInterface
    {
        return $this->fecResumen;
    }

    /**
     * @param DateTimeInterface $fecResumen
     *
     * @return Summary
     */
    public function setFecResumen(?DateTimeInterface $fecResumen): Summary
    {
        $this->fecResumen = $fecResumen;

        return $this;
    }

    /**
     * @return string
     */
    public function getMoneda(): ?string
    {
        return $this->moneda;
    }

    /**
     * @param string $moneda
     *
     * @return Summary
     */
    public function setMoneda(?string $moneda): Summary
    {
        $this->moneda = $moneda;

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
     * @return Summary
     */
    public function setCompany(?Company $company): Summary
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return SummaryDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param SummaryDetail[] $details
     *
     * @return Summary
     */
    public function setDetails(?array $details): Summary
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
        $fecResumenPe = $this->getDateWithTimezone($this->fecResumen);
        $parts = [
            'RC',
            $fecResumenPe->format('Ymd'),
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

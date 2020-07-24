<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:37 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Retention;

use DateTimeInterface;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Retention.
 */
class Retention implements DocumentInterface
{
    /**
     * Serie del Documento (ejem: R001).
     *
     * @var string
     */
    private $serie;

    /**
     * @var string
     */
    private $correlativo;

    /**
     * @var DateTimeInterface
     */
    private $fechaEmision;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var Client
     */
    private $proveedor;

    /**
     * @var string
     */
    private $regimen;

    /**
     * @var float
     */
    private $tasa;

    /**
     * Importe total Retenido.
     *
     * @var float
     */
    private $impRetenido;

    /**
     * Importe total Pagado.
     *
     * @var float
     */
    private $impPagado;

    /**
     * @var string
     */
    private $observacion;

    /**
     * Dato del Comprobante relacionado.
     *
     * @var RetentionDetail[]
     */
    private $details;

    /**
     * @return string
     */
    public function getSerie(): ?string
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     *
     * @return Retention
     */
    public function setSerie(?string $serie): Retention
    {
        $this->serie = $serie;

        return $this;
    }

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
     * @return Retention
     */
    public function setCorrelativo(?string $correlativo): Retention
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getFechaEmision(): ?DateTimeInterface
    {
        return $this->fechaEmision;
    }

    /**
     * @param DateTimeInterface $fechaEmision
     *
     * @return Retention
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): Retention
    {
        $this->fechaEmision = $fechaEmision;

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
     * @return Retention
     */
    public function setCompany(?Company $company): Retention
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Client
     */
    public function getProveedor(): ?Client
    {
        return $this->proveedor;
    }

    /**
     * @param Client $proveedor
     *
     * @return Retention
     */
    public function setProveedor(?Client $proveedor): Retention
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * @return string
     */
    public function getRegimen(): ?string
    {
        return $this->regimen;
    }

    /**
     * @param string $regimen
     *
     * @return Retention
     */
    public function setRegimen(?string $regimen): Retention
    {
        $this->regimen = $regimen;

        return $this;
    }

    /**
     * @return float
     */
    public function getTasa(): ?float
    {
        return $this->tasa;
    }

    /**
     * @param float $tasa
     *
     * @return Retention
     */
    public function setTasa(?float $tasa): Retention
    {
        $this->tasa = $tasa;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpRetenido(): ?float
    {
        return $this->impRetenido;
    }

    /**
     * @param float $impRetenido
     *
     * @return Retention
     */
    public function setImpRetenido(?float $impRetenido): Retention
    {
        $this->impRetenido = $impRetenido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPagado(): ?float
    {
        return $this->impPagado;
    }

    /**
     * @param float $impPagado
     *
     * @return Retention
     */
    public function setImpPagado(?float $impPagado): Retention
    {
        $this->impPagado = $impPagado;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    /**
     * @param string $observacion
     *
     * @return Retention
     */
    public function setObservacion(?string $observacion): Retention
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return RetentionDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param RetentionDetail[] $details
     *
     * @return Retention
     */
    public function setDetails(?array $details): Retention
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get FileName without extension.
     *
     * @return string
     */
    public function getName(): string
    {
        $parts = [
            $this->company->getRuc(),
            '20',
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:38 AM.
 */

declare(strict_types=1);

namespace Greenter\Model\Perception;

use DateTimeInterface;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;

/**
 * Class Perception.
 */
class Perception implements DocumentInterface
{
    /**
     * Serie del Documento (ejem: P001).
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
     * Importe total Percibido.
     *
     * @var float
     */
    private $impPercibido;

    /**
     * Importe total Cobrado.
     *
     * @var float
     */
    private $impCobrado;

    /**
     * @var string
     */
    private $observacion;

    /**
     * Dato del Comprobante relacionado.
     *
     * @var PerceptionDetail[]
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
     * @return Perception
     */
    public function setSerie(?string $serie): Perception
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
     * @return Perception
     */
    public function setCorrelativo(?string $correlativo): Perception
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
     * @return Perception
     */
    public function setFechaEmision(?DateTimeInterface $fechaEmision): Perception
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
     * @return Perception
     */
    public function setCompany(?Company $company): Perception
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
     * @return Perception
     */
    public function setProveedor(?Client $proveedor): Perception
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
     * @return Perception
     */
    public function setRegimen(?string $regimen): Perception
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
     * @return Perception
     */
    public function setTasa(?float $tasa): Perception
    {
        $this->tasa = $tasa;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpPercibido(): ?float
    {
        return $this->impPercibido;
    }

    /**
     * @param float $impPercibido
     *
     * @return Perception
     */
    public function setImpPercibido(?float $impPercibido): Perception
    {
        $this->impPercibido = $impPercibido;

        return $this;
    }

    /**
     * @return float
     */
    public function getImpCobrado(): ?float
    {
        return $this->impCobrado;
    }

    /**
     * @param float $impCobrado
     *
     * @return Perception
     */
    public function setImpCobrado(?float $impCobrado): Perception
    {
        $this->impCobrado = $impCobrado;

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
     * @return Perception
     */
    public function setObservacion(?string $observacion): Perception
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * @return PerceptionDetail[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }

    /**
     * @param PerceptionDetail[] $details
     *
     * @return Perception
     */
    public function setDetails(?array $details): Perception
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
            '40',
            $this->getSerie(),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}

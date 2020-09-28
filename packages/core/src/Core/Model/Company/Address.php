<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 21:03.
 */

declare(strict_types=1);

namespace Greenter\Model\Company;

/**
 * Class Address.
 */
class Address
{
    /**
     * @var string|null
     */
    private $ubigueo;

    /**
     * @var string|null
     */
    private $codigoPais = 'PE';

    /**
     * @var string|null
     */
    private $departamento;

    /**
     * @var string|null
     */
    private $provincia;

    /**
     * @var string|null
     */
    private $distrito;

    /**
     * @var string|null
     */
    private $urbanizacion;

    /**
     * @var string|null
     */
    private $direccion;

    /**
     * Codigo Local Anexo.
     *
     * @var string|null
     */
    private $codLocal = '0000';

    /**
     * @return string|null
     */
    public function getUbigueo(): ?string
    {
        return $this->ubigueo;
    }

    /**
     * @param string|null $ubigueo
     *
     * @return Address
     */
    public function setUbigueo(?string $ubigueo): Address
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodigoPais(): ?string
    {
        return $this->codigoPais;
    }

    /**
     * @param string|null $codigoPais
     *
     * @return Address
     */
    public function setCodigoPais(?string $codigoPais): Address
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    /**
     * @param string|null $departamento
     *
     * @return Address
     */
    public function setDepartamento(?string $departamento): Address
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    /**
     * @param string|null $provincia
     *
     * @return Address
     */
    public function setProvincia(?string $provincia): Address
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDistrito(): ?string
    {
        return $this->distrito;
    }

    /**
     * @param string|null $distrito
     *
     * @return Address
     */
    public function setDistrito(?string $distrito): Address
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrbanizacion(): ?string
    {
        return $this->urbanizacion;
    }

    /**
     * @param string|null $urbanizacion
     *
     * @return Address
     */
    public function setUrbanizacion(?string $urbanizacion): Address
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * @param string|null $direccion
     *
     * @return Address
     */
    public function setDireccion(?string $direccion): Address
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodLocal(): ?string
    {
        return $this->codLocal;
    }

    /**
     * @param string|null $codLocal
     *
     * @return Address
     */
    public function setCodLocal(?string $codLocal): Address
    {
        $this->codLocal = $codLocal;

        return $this;
    }
}

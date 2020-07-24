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
     * @var string
     */
    private $ubigueo;

    /**
     * @var string
     */
    private $codigoPais = 'PE';

    /**
     * @var string
     */
    private $departamento;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var string
     */
    private $distrito;

    /**
     * @var string
     */
    private $urbanizacion;

    /**
     * @var string
     */
    private $direccion;

    /**
     * Codigo Local Anexo.
     *
     * @var string
     */
    private $codLocal = '0000';

    /**
     * @return string
     */
    public function getUbigueo(): ?string
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
     *
     * @return Address
     */
    public function setUbigueo(?string $ubigueo): Address
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoPais(): ?string
    {
        return $this->codigoPais;
    }

    /**
     * @param string $codigoPais
     *
     * @return Address
     */
    public function setCodigoPais(?string $codigoPais): Address
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * @return string
     */
    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     *
     * @return Address
     */
    public function setDepartamento(?string $departamento): Address
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     *
     * @return Address
     */
    public function setProvincia(?string $provincia): Address
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrito(): ?string
    {
        return $this->distrito;
    }

    /**
     * @param string $distrito
     *
     * @return Address
     */
    public function setDistrito(?string $distrito): Address
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrbanizacion(): ?string
    {
        return $this->urbanizacion;
    }

    /**
     * @param string $urbanizacion
     *
     * @return Address
     */
    public function setUrbanizacion(?string $urbanizacion): Address
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     *
     * @return Address
     */
    public function setDireccion(?string $direccion): Address
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodLocal(): ?string
    {
        return $this->codLocal;
    }

    /**
     * @param string $codLocal
     *
     * @return Address
     */
    public function setCodLocal(?string $codLocal): Address
    {
        $this->codLocal = $codLocal;

        return $this;
    }
}

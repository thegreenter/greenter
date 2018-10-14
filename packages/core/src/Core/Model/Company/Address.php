<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 21:03.
 */

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
     * Codigo Local Anexo
     *
     * @var string
     */
    private $codLocal = '0000';

    /**
     * @return string
     */
    public function getUbigueo()
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
     *
     * @return Address
     */
    public function setUbigueo($ubigueo)
    {
        $this->ubigueo = $ubigueo;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodigoPais()
    {
        return $this->codigoPais;
    }

    /**
     * @param string $codigoPais
     *
     * @return Address
     */
    public function setCodigoPais($codigoPais)
    {
        $this->codigoPais = $codigoPais;

        return $this;
    }

    /**
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento
     *
     * @return Address
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     *
     * @return Address
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrito()
    {
        return $this->distrito;
    }

    /**
     * @param string $distrito
     *
     * @return Address
     */
    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrbanizacion()
    {
        return $this->urbanizacion;
    }

    /**
     * @param string $urbanizacion
     *
     * @return Address
     */
    public function setUrbanizacion($urbanizacion)
    {
        $this->urbanizacion = $urbanizacion;

        return $this;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     *
     * @return Address
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * @param string $codLocal
     * @return Address
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 21:03
 */

namespace Greenter\Xml\Model\Company;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Address
 * @package Greenter\Xml\Model\Company
 */
class Address
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="6")
     * @var string
     */
    private $ubigueo;

    /**
     * @Assert\Length(max="2")
     * @var string
     */
    private $codigoPais;

    /**
     * @Assert\Length(max="30")
     * @var string
     */
    private $departamento;

    /**
     * @Assert\Length(max="30")
     * @var string
     */
    private $provincia;

    /**
     * @Assert\Length(max="100")
     * @var string
     */
    private $distrito;

    /**
     * @Assert\Length(max="25")
     * @var string
     */
    private $urbanizacion;

    /**
     * @Assert\Length(max="100")
     * @var string
     */
    private $direccion;

    /**
     * Address constructor.
     */
    public function __construct()
    {
        $this->codigoPais = 'PE';
    }

    /**
     * @return string
     */
    public function getUbigueo()
    {
        return $this->ubigueo;
    }

    /**
     * @param string $ubigueo
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
     * @return Address
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
        return $this;
    }
}
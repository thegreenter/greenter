<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 21:03
 */

namespace Greenter\Model\Company;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Company
 * @package Greenter\Xml\Model\Company
 */
class Company
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="11", min="11")
     * @var string
     */
    private $ruc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    private $razonSocial;

    /**
     * @Assert\Length(max="100")
     * @var string
     */
    private $nombreComercial;

    /**
     * @Assert\Valid()
     * @var Address
     */
    private $address;

    /**
     * @return string
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param string $ruc
     * @return Company
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
        return $this;
    }

    /**
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @param string $razonSocial
     * @return Company
     */
    public function setRazonSocial($razonSocial)
    {
        $this->razonSocial = $razonSocial;
        return $this;
    }

    /**
     * @return string
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * @param string $nombreComercial
     * @return Company
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Company
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
}
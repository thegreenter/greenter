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
 * Class Company.
 */
class Company
{
    /**
     * @var string
     */
    private $ruc;

    /**
     * @var string
     */
    private $razonSocial;

    /**
     * @var string
     */
    private $nombreComercial;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @return string
     */
    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    /**
     * @param string $ruc
     *
     * @return Company
     */
    public function setRuc(?string $ruc): Company
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * @return string
     */
    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    /**
     * @param string $razonSocial
     *
     * @return Company
     */
    public function setRazonSocial(?string $razonSocial): Company
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * @return string
     */
    public function getNombreComercial(): ?string
    {
        return $this->nombreComercial;
    }

    /**
     * @param string $nombreComercial
     *
     * @return Company
     */
    public function setNombreComercial(?string $nombreComercial): Company
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return Company
     */
    public function setAddress(?Address $address): Company
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Company
     */
    public function setEmail(?string $email): Company
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     *
     * @return Company
     */
    public function setTelephone(?string $telephone): Company
    {
        $this->telephone = $telephone;

        return $this;
    }
}

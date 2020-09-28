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
     * @var string|null
     */
    private $ruc;

    /**
     * @var string|null
     */
    private $razonSocial;

    /**
     * @var string|null
     */
    private $nombreComercial;

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $telephone;

    /**
     * @return string|null
     */
    public function getRuc(): ?string
    {
        return $this->ruc;
    }

    /**
     * @param string|null $ruc
     *
     * @return Company
     */
    public function setRuc(?string $ruc): Company
    {
        $this->ruc = $ruc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    /**
     * @param string|null $razonSocial
     *
     * @return Company
     */
    public function setRazonSocial(?string $razonSocial): Company
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNombreComercial(): ?string
    {
        return $this->nombreComercial;
    }

    /**
     * @param string|null $nombreComercial
     *
     * @return Company
     */
    public function setNombreComercial(?string $nombreComercial): Company
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     *
     * @return Company
     */
    public function setAddress(?Address $address): Company
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     *
     * @return Company
     */
    public function setEmail(?string $email): Company
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string|null $telephone
     *
     * @return Company
     */
    public function setTelephone(?string $telephone): Company
    {
        $this->telephone = $telephone;

        return $this;
    }
}

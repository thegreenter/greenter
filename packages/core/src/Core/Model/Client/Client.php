<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:01.
 */

declare(strict_types=1);

namespace Greenter\Model\Client;

use Greenter\Model\Company\Address;

/**
 * Class Client.
 */
class Client
{
    /**
     * @var string
     */
    private $tipoDoc;

    /**
     * @var string
     */
    private $numDoc;

    /**
     * @var string
     */
    private $rznSocial;

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
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return Client
     */
    public function setTipoDoc(?string $tipoDoc): Client
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc(): ?string
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     *
     * @return Client
     */
    public function setNumDoc(?string $numDoc): Client
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getRznSocial(): ?string
    {
        return $this->rznSocial;
    }

    /**
     * @param string $rznSocial
     *
     * @return Client
     */
    public function setRznSocial(?string $rznSocial): Client
    {
        $this->rznSocial = $rznSocial;

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
     * @return Client
     */
    public function setAddress(?Address $address): Client
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
     * @return Client
     */
    public function setEmail(?string $email): Client
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
     * @return Client
     */
    public function setTelephone(?string $telephone): Client
    {
        $this->telephone = $telephone;

        return $this;
    }
}

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
     * @var string|null
     */
    private $tipoDoc;

    /**
     * @var string|null
     */
    private $numDoc;

    /**
     * @var string|null
     */
    private $rznSocial;

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
    public function getTipoDoc(): ?string
    {
        return $this->tipoDoc;
    }

    /**
     * @param string|null $tipoDoc
     *
     * @return Client
     */
    public function setTipoDoc(?string $tipoDoc): Client
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumDoc(): ?string
    {
        return $this->numDoc;
    }

    /**
     * @param string|null $numDoc
     *
     * @return Client
     */
    public function setNumDoc(?string $numDoc): Client
    {
        $this->numDoc = $numDoc;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRznSocial(): ?string
    {
        return $this->rznSocial;
    }

    /**
     * @param string|null $rznSocial
     *
     * @return Client
     */
    public function setRznSocial(?string $rznSocial): Client
    {
        $this->rznSocial = $rznSocial;

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
     * @return Client
     */
    public function setAddress(?Address $address): Client
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
     * @return Client
     */
    public function setEmail(?string $email): Client
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
     * @return Client
     */
    public function setTelephone(?string $telephone): Client
    {
        $this->telephone = $telephone;

        return $this;
    }
}

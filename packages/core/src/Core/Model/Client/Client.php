<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:01
 */

namespace Greenter\Model\Client;

use Greenter\Model\Company\Address;
use Greenter\Xml\Validator\ClientValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Client
 * @package Greenter\Model\Client
 */
class Client
{
    use ClientValidator;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="1")
     * @var string
     */
    private $tipoDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="15")
     * @var string
     */
    private $numDoc;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="100")
     * @var string
     */
    private $rznSocial;

    /**
     * @Assert\Valid()
     * @var Address
     */
    private $address;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     * @return Client
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumDoc()
    {
        return $this->numDoc;
    }

    /**
     * @param string $numDoc
     * @return Client
     */
    public function setNumDoc($numDoc)
    {
        $this->numDoc = $numDoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getRznSocial()
    {
        return $this->rznSocial;
    }

    /**
     * @param string $rznSocial
     * @return Client
     */
    public function setRznSocial($rznSocial)
    {
        $this->rznSocial = $rznSocial;
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
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
}
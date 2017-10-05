<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:01
 */

namespace Greenter\Model\Client;

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
     * @return mixed
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param mixed $tipoDoc
     * @return Client
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumDoc()
    {
        return $this->numDoc;
    }

    /**
     * @param mixed $numDoc
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
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 23:13
 */

namespace Greenter\Ws\Services;

use Greenter\Ws\Header\WSSESecurityHeader;
use SoapClient;

class BaseSunat
{
    /**
     * Url del servicio.
     * @var string
     */
    private $service;

    /**
     * Usuario (RUC + User SOL).
     * @var string
     */
    private $user;
    /**
     * Clave SOL
     *
     * @var string
     */
    private $password;

    /**
     * Parametros del Soap.
     * @var array
     */
    protected $parameters = [];

    /**
     * Url del WSDL.
     * @var string
     */
    protected $urlWsdl;

    /**
     * Set Credentiasl WebService.
     *
     * @param string $user
     * @param string $password
     */
    public function setCrentials($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Create a new SoapClient.
     * @return SoapClient
     */
    public function getClient()
    {
        $client = new SoapClient($this->urlWsdl, $this->parameters);
        $client->__setLocation($this->service);
        $client->__setSoapHeaders(new WSSESecurityHeader($this->user, $this->password));
        return $client;
    }

    /**
     * Set Service of SUNAT.
     *
     * @param string $service
     * @return BaseSunat
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * Set Url del WSDL.
     *
     * @param string $urlWsdl
     * @return BaseSunat
     */
    public function setUrlWsdl($urlWsdl)
    {
        $this->urlWsdl = $urlWsdl;
        return $this;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 6/11/2018
 * Time: 12:12.
 */

namespace Greenter\Ws\Services;

/**
 * Class ServiceBuilder.
 */
class ServiceBuilder
{
    private $wsdl = '';
    private $wsdlParams = [];
    private $url;
    private $user;
    private $password;

    /**
     * @param mixed $url
     *
     * @return ServiceBuilder
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param mixed $wsdl
     *
     * @return ServiceBuilder
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    /**
     * @param mixed $wsdlParams
     *
     * @return ServiceBuilder
     */
    public function setWsdlParams($wsdlParams)
    {
        $this->wsdlParams = $wsdlParams;

        return $this;
    }

    /**
     * @param mixed $user
     *
     * @return ServiceBuilder
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param mixed $password
     *
     * @return ServiceBuilder
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $type Service Class
     * @return mixed
     * @throws \Exception
     */
    public function build($type)
    {
        if (!is_subclass_of($type, BaseSunat::class)) {
            throw new \Exception($type.' should be instance of '.BaseSunat::class);
        }

        $client = new SoapClient($this->wsdl, $this->wsdlParams);
        $client->setCredentials($this->user, $this->password);
        $client->setService($this->url);

        /** @var $service BaseSunat */
        $service = new $type();
        $service->setClient($client);

        return $service;
    }
}

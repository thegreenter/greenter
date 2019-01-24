<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 23/01/2019
 * Time: 16:35.
 */

namespace Greenter\Ws\Builder;

use Greenter\Ws\Services\SoapClient;

/**
 * Class SoapBuilder.
 */
class SoapBuilder
{
    private $url;
    private $wsdl = '';
    private $wsdlParams = [];
    private $user;
    private $password;

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param mixed $wsdl
     *
     * @return $this
     */
    public function setWsdl($wsdl)
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    /**
     * @param array $wsdlParams
     *
     * @return $this
     */
    public function setWsdlParams(array $wsdlParams)
    {
        $this->wsdlParams = $wsdlParams;

        return $this;
    }

    /**
     * @param string $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return SoapClient
     */
    public function build()
    {
        $client = new SoapClient($this->wsdl, $this->wsdlParams);
        $client->setCredentials($this->user, $this->password);

        return $client;
    }
}

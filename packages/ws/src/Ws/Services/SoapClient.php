<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 03/10/2017
 * Time: 09:47 AM.
 */

namespace Greenter\Ws\Services;

use Greenter\Ws\Header\WSSESecurityHeader;
use SoapFault;

/**
 * Class SoapClient.
 */
class SoapClient extends \SoapClient implements WsClientInterface
{
    /**
     * SoapClient constructor.
     *
     * @param string $wsdl       Url of WSDL
     * @param array  $parameters Soap's parameters
     *
     * @throws SoapFault
     */
    public function __construct($wsdl = '', $parameters = [])
    {
        if (empty($wsdl)) {
            $wsdl = WsdlProvider::getBillPath();
        }
        parent::__construct($wsdl, $parameters);
    }

    /**
     * @param $user
     * @param $password
     */
    public function setCredentials($user, $password)
    {
        $this->__setSoapHeaders(new WSSESecurityHeader($user, $password));
    }

    /**
     * Set Url of Service.
     *
     * @param string $url
     */
    public function setService($url)
    {
        $this->__setLocation($url);
    }

    /**
     * @param $function
     * @param $arguments
     *
     * @return mixed
     */
    public function call($function, $arguments)
    {
        return $this->__soapCall($function, $arguments);
    }
}

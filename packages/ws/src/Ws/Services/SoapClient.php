<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 03/10/2017
 * Time: 09:47 AM.
 */

declare(strict_types=1);

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
	if (empty($parameters)) {
		$parameters=[
			'stream_context' => stream_context_create([
				'ssl' => [
					// 'ciphers'=>'AES256-SHA',
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				],
			]),
		];
	}
        parent::__construct($wsdl, $parameters);
    }

    /**
     * @param string $user
     * @param string $password
     */
    public function setCredentials(?string $user, ?string $password)
    {
        $this->__setSoapHeaders(new WSSESecurityHeader($user, $password));
    }

    /**
     * Set Url of Service.
     *
     * @param string $url
     */
    public function setService(?string $url)
    {
        $this->__setLocation($url);
    }

    /**
     * @param string $function
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function call($function, $arguments)
    {
        return $this->__soapCall($function, $arguments);
    }
}

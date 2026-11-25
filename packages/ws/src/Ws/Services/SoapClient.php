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
     * Si no se especifican `$parameters`, la conexión NO verifica el certificado TLS del servidor.
     * Use {@see SoapClient::createSecure()} o {@see SoapClient::secureParameters()} para verificarlo;
     * en Greenter 6 la verificación TLS será el comportamiento por defecto.
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
            $parameters = self::insecureParameters();
        }

        parent::__construct($wsdl, $parameters);
    }

    /**
     * Crea un cliente que verifica el certificado TLS del servidor (recomendado).
     *
     * @param string $wsdl       Url of WSDL, por defecto el WSDL local de billService
     * @param array  $sslOptions Opciones ssl adicionales del stream context, ejm: ['cafile' => '/path/cacert.pem']
     * @param array  $parameters Soap's parameters adicionales
     *
     * @throws SoapFault
     */
    public static function createSecure(string $wsdl = '', array $sslOptions = [], array $parameters = []): self
    {
        return new self($wsdl, array_merge($parameters, self::secureParameters($sslOptions)));
    }

    /**
     * Parámetros SOAP con verificación TLS del servidor habilitada.
     *
     * @param array $sslOptions Opciones ssl adicionales del stream context, ejm: ['cafile' => '/path/cacert.pem']
     *
     * @return array
     */
    public static function secureParameters(array $sslOptions = []): array
    {
        return [
            'stream_context' => stream_context_create([
                'ssl' => array_merge([
                    'verify_peer' => true,
                    'verify_peer_name' => true,
                    'allow_self_signed' => false,
                ], $sslOptions),
            ]),
        ];
    }

    private static function insecureParameters(): array
    {
        return [
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]),
        ];
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

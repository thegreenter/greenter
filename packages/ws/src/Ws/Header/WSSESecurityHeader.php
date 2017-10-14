<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:54
 */

namespace Greenter\Ws\Header;

use SoapHeader;
use SoapVar;

/**
 * Class WSSESecurityHeader
 * @package Greenter\Ws\Security
 */
class WSSESecurityHeader extends SoapHeader {

    public function __construct($username, $password)
    {
        $wsseNamespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
        $security = new SoapVar(
            array(new SoapVar(
                array(
                    new SoapVar($username, XSD_STRING, null, null, 'Username', $wsseNamespace),
                    new SoapVar($password, XSD_STRING, null, null, 'Password', $wsseNamespace)
                ),
                SOAP_ENC_OBJECT,
                null,
                null,
                'UsernameToken',
                $wsseNamespace
            )),
            SOAP_ENC_OBJECT
        );
        $this->SoapHeader($wsseNamespace, 'Security', $security, false);
    }
}
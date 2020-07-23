<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:54.
 */

namespace Greenter\Ws\Header;

use SoapHeader;
use SoapVar;

/**
 * Class WSSESecurityHeader.
 */
class WSSESecurityHeader extends SoapHeader
{
    const WSS_NAMESPACE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    const PASSWORD_TYPE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText';
    const PASSWORD_FORMAT = '<o:Password xmlns:o="%s" Type="%s">%s</o:Password>';

    public function __construct($username, $password)
    {
        $passwordXml = sprintf(self::PASSWORD_FORMAT, self::WSS_NAMESPACE, self::PASSWORD_TYPE, $password);
        $security = new SoapVar(
            [new SoapVar(
                [
                    new SoapVar($username, XSD_STRING, null, null, 'Username', self::WSS_NAMESPACE),
                    new SoapVar($passwordXml, XSD_ANYXML),
                ],
                SOAP_ENC_OBJECT,
                null,
                null,
                'UsernameToken',
                self::WSS_NAMESPACE
            )],
            SOAP_ENC_OBJECT
        );
        parent::__construct(self::WSS_NAMESPACE, 'Security', $security, false);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 04:33 PM
 */

namespace tests\Greenter\Security;

use Greenter\XMLSecLibs\Sunat\SunatXmlSecAdapter;

/**
 * Class SignedXmlTest
 * @package tests\Greenter\Security
 */
class SignedXmlTest extends \PHPUnit_Framework_TestCase
{
    public function testSignXml()
    {
        $xmlSigned = $this->createXmlSigned();

        $this->assertNotEmpty($xmlSigned);
        $this->assertXmlSigned($xmlSigned);
    }

    public function testVerifyXml()
    {
        $xmlSigned = $this->createXmlSigned();

        $signer = new SunatXmlSecAdapter();
        $result = $signer->verifyXml($xmlSigned);

        $this->assertTrue($result);
    }

    private function assertXmlSigned($xml)
    {
        @$sXml = new \SimpleXMLElement($xml);
        $signs = $sXml->xpath('//ds:SignedInfo');
        $this->assertEquals(1, count($signs));
    }

    private function createXmlSigned()
    {
        $xml = file_get_contents(__DIR__ . '/../../Resources/invoice.xml');
        $cert = file_get_contents(__DIR__ . '/../../Resources/SFSCert.pem');
        $signer = new SunatXmlSecAdapter();
        $signer->setCertificate($cert);
        $xmlSigned = $signer->signXml($xml);

        //file_put_contents('signed.xml', $xmlSigned);
        return $xmlSigned;
    }
}
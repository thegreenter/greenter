<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 04:33 PM
 */

namespace tests\Greenter\Security;

use Greenter\Security\SignedXml;

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
        $key = file_get_contents(__DIR__ . '/../Resources/certificado.cer');
        $xmlSigned = $this->createXmlSigned();

        $signer = new SignedXml();
        $signer->setPublicKey($key);
        $result = $signer->verify($xmlSigned);

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
        $xml = file_get_contents(__DIR__ . '/../Resources/invoice.xml');
        $key = file_get_contents(__DIR__ . '/../Resources/certificado.key');
        $signer = new SignedXml();
        $signer->setPrivateKey($key);
        $xmlSigned = $signer->sign($xml);

        file_put_contents('signed.xml', $xmlSigned);
        return $xmlSigned;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:39
 */

namespace Greenter\Security;

use RobRichards\XMLSecLibs\Sunat\Adapter\SunatXmlSecAdapter;

/**
 * Class SignedXml
 * @package Greenter\Security
 */
class SignedXml
{
    /**
     * @var SunatXmlSecAdapter
     */
    private $adapter;

    /**
     * SignedXml constructor.
     */
    public function __construct()
    {
        $this->adapter = new SunatXmlSecAdapter();
    }

    /**
     * Firma el contenido del xml y retorna el contenido firmado.
     *
     * @param string $content
     * @return string
     */
    public function sign($content)
    {
        $doc = $this->getDocXml($content);

        $this->adapter->sign($doc);
        return $doc->saveXML();
    }

    /**
     * Verifica la firma del xml.
     *
     * @param string $content
     * @return bool
     */
    public function verify($content)
    {
        $doc = $this->getDocXml($content);
        $this->adapter->getPublicKey($doc);

        return $this->adapter->verify($doc);
    }

    /**
     * @param string $cert
     */
    public function setCertificate($cert)
    {
        $this->adapter->setPrivateKey($cert);
        $this->adapter->setPublicKey($cert);
    }

    /**
     * @param string $content
     * @return \DOMDocument
     */
    private function getDocXml($content)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        return $doc;
    }
}
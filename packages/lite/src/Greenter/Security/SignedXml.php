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
     * @var XmlseclibsAdapter
     */
    private $adapter;

    /**
     * SignedXml constructor.
     */
    public function __construct()
    {
        $this->adapter = new SunatXmlSecAdapter();
        $this->adapter->addTransform(SunatXmlSecAdapter::ENVELOPED);
        $this->adapter->setCanonicalMethod(SunatXmlSecAdapter::XML_C14N);
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

        return $this->adapter->verify($doc);
    }

    /**
     * @param string $key
     */
    public function setPrivateKey($key)
    {
        $this->adapter->setPrivateKey($key);
    }

    /**
     * @param string $key
     */
    public function setPublicKey($key)
    {
        $this->adapter->setPublicKey($key);
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
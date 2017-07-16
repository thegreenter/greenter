<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:39
 */

namespace Greenter\Security;

use FR3D\XmlDSig\Adapter\XmlseclibsAdapter;

/**
 * Class SignedXml
 * @package Greenter\Security
 */
class SignedXml
{
    /**
     * @var string
     */
    private $key;

    /**
     * Firma el contenido del xml y retorna el contenido firmado.
     *
     * @param string $content
     * @return string
     */
    public function sign($content)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        $adapter = $this->createXmlAdapter();
        $adapter->sign($doc);
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
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        $adapter = $this->createXmlAdapter();
        return $adapter->verify($doc);
    }

    /**
     * @param string $certify
     */
    public function setCertificate($certify)
    {
        $this->key = $certify;
    }

    /**
     * @return XmlseclibsAdapter
     */
    protected function createXmlAdapter()
    {
        $adapter = new XmlseclibsAdapter();
        $adapter->setPrivateKey($this->key);
        $adapter->addTransform(XmlseclibsAdapter::ENVELOPED);
        return $adapter;
    }
}
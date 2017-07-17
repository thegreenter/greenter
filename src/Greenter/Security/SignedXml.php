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
     * @var XmlseclibsAdapter
     */
    private $adapter;

    /**
     * SignedXml constructor.
     */
    public function __construct()
    {
        $this->adapter = new XmlseclibsAdapter();
        $this->adapter->addTransform(XmlseclibsAdapter::ENVELOPED);
    }

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
        $doc = new \DOMDocument();
        $doc->loadXML($content);

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
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 04:41 PM.
 */

namespace Greenter\Report;

/**
 * Class XmlUtils.
 */
final class XmlUtils
{
    const EXT_NAMESPACE = 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2';
    const DS_NAMESPACE = 'http://www.w3.org/2000/09/xmldsig#';
    const DIGEST_QUERY = 'ext:ExtensionContent/ds:Signature/ds:SignedInfo/ds:Reference/ds:DigestValue';

    /**
     * @param string $xml
     *
     * @return string
     */
    public function getHashSign($xml)
    {
        $doc = new \DOMDocument();
        @$doc->loadXML($xml);

        return $this->getHashSignFromDoc($doc);
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public function getHashSignFromFile($filename)
    {
        $doc = new \DOMDocument();
        @$doc->load($filename);

        return $this->getHashSignFromDoc($doc);
    }

    /**
     * @param \DOMDocument $document
     *
     * @return string
     */
    public function getHashSignFromDoc(\DOMDocument $document)
    {
        $xpt = $this->getXpath($document);

        $exts = $xpt->query('ext:UBLExtensions/ext:UBLExtension', $document->documentElement);
        if ($exts->length == 0) {
            return '';
        }

        return $this->getHash($exts, $xpt);
    }

    /**
     * @param \DOMDocument $document
     *
     * @return \DOMXPath
     */
    private function getXpath(\DOMDocument $document)
    {
        $xpt = new \DOMXPath($document);
        $xpt->registerNamespace('ext', self::EXT_NAMESPACE);
        $xpt->registerNamespace('ds', self::DS_NAMESPACE);

        return $xpt;
    }

    /**
     * @param \DOMNodeList $exts
     * @param \DOMXPath $xpt
     * @return string
     */
    private function getHash(\DOMNodeList $exts, \DOMXPath $xpt)
    {
        for ($i = $exts->length; $i-- > 0;) {
            $nodeSign = $exts->item($i);
            $hash = $xpt->query(self::DIGEST_QUERY, $nodeSign);

            if ($hash->length == 0) {
                continue;
            }

            return $hash->item(0)->nodeValue;
        }

        return '';
    }
}

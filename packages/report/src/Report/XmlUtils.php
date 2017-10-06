<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 04:41 PM
 */

namespace Greenter\Report;

/**
 * Class XmlUtils
 * @package Greenter\Report
 */
final class XmlUtils
{
    /**
     * @param string $xml
     * @return string
     */
    public static function extractSign($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);

        return self::extractSignFromDoc($doc);
    }

    /**
     * @param \DOMDocument $document
     * @return string
     */
    public static function extractSignFromDoc(\DOMDocument $document)
    {
        $xpt = new \DOMXPath($document);

        $exts = $xpt->query('ext:UBLExtensions/ext:UBLExtension', $document->documentElement);
        if ($exts->length == 0) {
            return '';
        }
        $nodeSign = $exts->item($exts->length - 1);

        $hash = $xpt->query('ext:ExtensionContent/ds:Signature/ds:SignedInfo/ds:Reference/ds:DigestValue', $nodeSign);

        if ($hash->length == 0) {
            return '';
        }

        return $hash->item(0)->nodeValue;
    }
}
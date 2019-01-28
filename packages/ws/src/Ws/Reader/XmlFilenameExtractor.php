<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 24/01/2019
 * Time: 16:12
 */

namespace Greenter\Ws\Reader;

/**
 * Class XmlFilenameExtractor
 * @package Greenter\Ws\Reader
 */
class XmlFilenameExtractor implements FilenameExtractorInterface
{
    const CONCAT_CHR = '-';
    /**
     * Prefix namespace.
     */
    const ROOT_PREFIX = 'x';

    /**
     * @var \DOMXPath
     */
    protected $xpath;
    /**
     * @var string
     */
    private $rootNs;

    /**
     * @param \DOMDocument|string $content
     *
     * @return string
     * @throws \Exception
     */
    public function getFilename($content)
    {
        $this->load($content);

        $nameType = $this->xpath->document->documentElement->nodeName;
        $ruc = $this->getRuc($nameType);
        $document = $this->getFirst('cbc:ID');

        $type = $this->getTypeFromDoc($nameType);
        if (empty($type)) {
            return $ruc.self::CONCAT_CHR.$document;
        }

        return implode(self::CONCAT_CHR, [$ruc, $type, $document]);
    }

    private function load($value)
    {
        $doc = $value instanceof \DOMDocument ? $value : $this->getDoc($value);

        $this->loadXpath($doc);
    }

    private function getRuc($nameType)
    {
        if ($nameType === 'Perception' || $nameType == 'Retention') {
            return $this->getFirst('cac:AgentParty/cac:PartyIdentification/cbc:ID');
        }

        $ubl = $this->getFirst('cbc:UBLVersionID');
        switch ($ubl) {
            case '2.0':
                return $this->getFirst('cac:AccountingSupplierParty/cbc:CustomerAssignedAccountID');
                break;
            case '2.1':
                return $this->getFirst('cac:AccountingSupplierParty/cac:Party/cac:PartyIdentification/cbc:ID');
                break;
            default:
                throw new \Exception("UBL version $ubl no soportada.");
        }
    }

    private function getDoc($content)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($content);

        return $doc;
    }

    private function loadXpath(\DOMDocument $doc)
    {
        $docName = $doc->documentElement->nodeName;
        $this->rootNs = '/' . self::ROOT_PREFIX . ':' . $docName;
        $this->xpath = new \DOMXPath($doc);
        $this->xpath->registerNamespace(self::ROOT_PREFIX, $doc->documentElement->namespaceURI);
    }

    /***
     * Obtiene el primer valor del nodo.
     *
     * @param string $query Relativo al root namespace
     * @return null|string
     */
    private function getFirst($query)
    {
        $nodes = $this->xpath->query($this->rootNs . '/' . $query);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }
        return null;
    }

    private function getTypeFromDoc($name)
    {
        //$this->xpath->document->documentElement->nodeName;
        switch ($name) {
            case 'Invoice':
                return $this->getFirst('cbc:InvoiceTypeCode');
            case 'CreditNote':
                return '07';
            case 'DebitNote':
                return '08';
            case 'Perception':
                return '40';
            case 'Retention':
                return '20';
            default:
                return '';
        }
    }
}
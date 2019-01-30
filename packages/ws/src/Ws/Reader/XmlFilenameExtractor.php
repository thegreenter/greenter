<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 24/01/2019
 * Time: 16:12.
 */

namespace Greenter\Ws\Reader;

/**
 * Class XmlFilenameExtractor.
 */
class XmlFilenameExtractor implements FilenameExtractorInterface
{
    const CONCAT_CHR = '-';

    /**
     * @var XmlReader
     */
    private $reader;

    /**
     * XmlFilenameExtractor constructor.
     *
     * @param XmlReader $reader
     */
    public function __construct(XmlReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param \DOMDocument|string $content
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getFilename($content)
    {
        $doc = $this->reader->parseToDocument($content);
        $this->reader->loadXpathFromDoc($doc);

        $nameType = $doc->documentElement->localName;
        $ruc = $this->getRuc($nameType);
        $document = $this->reader->getValue('cbc:ID');

        $type = $this->getTypeFromDoc($nameType);
        if (empty($type)) {
            return $ruc.self::CONCAT_CHR.$document;
        }

        return implode(self::CONCAT_CHR, [$ruc, $type, $document]);
    }

    /**
     * @param $nameType
     * @return null|string
     * @throws \Exception
     */
    private function getRuc($nameType)
    {
        if ('Perception' === $nameType || 'Retention' == $nameType) {
            return $this->reader->getValue('cac:AgentParty/cac:PartyIdentification/cbc:ID');
        }

        $ubl = $this->reader->getValue('cbc:UBLVersionID');
        switch ($ubl) {
            case '2.0':
                return $this->reader->getValue('cac:AccountingSupplierParty/cbc:CustomerAssignedAccountID');
                break;
            case '2.1':
                return $this->reader->getValue('cac:AccountingSupplierParty/cac:Party/cac:PartyIdentification/cbc:ID');
                break;
            default:
                throw new \Exception("UBL version $ubl no soportada.");
        }
    }

    private function getTypeFromDoc($name)
    {
        switch ($name) {
            case 'Invoice':
                return $this->reader->getValue('cbc:InvoiceTypeCode');
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

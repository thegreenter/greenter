<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 22/07/2017
 * Time: 15:40.
 */

declare(strict_types=1);

namespace Greenter\Ws\Reader;

use Greenter\Model\Response\CdrResponse;

/**
 * Class DomCdrReader.
 */
class DomCdrReader implements CdrReaderInterface
{
    /**
     * @var XmlReader
     */
    private $reader;

    /**
     * DomCdrReader constructor.
     * @param XmlReader $reader
     */
    public function __construct(XmlReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Get Cdr using DomDocument.
     *
     * @param string $xml
     *
     * @return CdrResponse|null
     */
    public function getCdrResponse(?string $xml): ?CdrResponse
    {
        if (empty($xml)) {
            throw new XmlReaderException('XML del CDR no puede estar vacío.');
        }

        $this->loadXml($xml);

        return $this->createCdr();
    }

    /**
     * @return CdrResponse
     */
    private function createCdr(): CdrResponse
    {
        $nodePrefix = 'cac:DocumentResponse/cac:Response/';
        $referencePath = 'cac:DocumentResponse/cac:DocumentReference/cbc:DocumentDescription';

        $cdr = new CdrResponse();
        $cdr->setId($this->reader->getValue($nodePrefix.'cbc:ReferenceID'))
            ->setCode($this->reader->getValue($nodePrefix.'cbc:ResponseCode'))
            ->setDescription($this->reader->getValue($nodePrefix.'cbc:Description'))
            ->setNotes($this->getNotes())
            ->setReference($this->reader->getValue($referencePath));

        return $cdr;
    }

    /**
     * Get Notes if exist.
     *
     * @return string[]
     */
    private function getNotes(): array
    {
        $xpath = $this->reader->getXpath();

        $nodes = $xpath->query($this->reader->getRoot().'/cbc:Note');
        $notes = [];
        if ($nodes->length === 0) {
            return $notes;
        }

        /** @var \DOMElement $node */
        foreach ($nodes as $node) {
            $notes[] = $node->nodeValue ?? '';
        }

        return $notes;
    }

    private function loadXml(string $xml): void
    {
        $this->reader->loadXpath($xml);
        $xpath = $this->reader->getXpath();
        $xpath->registerNamespace('cac', UblNs::CAC);
        $xpath->registerNamespace('cbc', UblNs::CBC);
    }
}

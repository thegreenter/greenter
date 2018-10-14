<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 24/01/2018
 * Time: 10:14 AM
 */

namespace Tests\Greenter\Xml\Builder;
use Greenter\Ubl\SchemaValidator;
use Greenter\Ubl\SchemaValidatorInterface;

/**
 * Trait XsdValidatorTrait
 * @method assertTrue($state)
 */
trait XsdValidatorTrait
{
    private $CbcNs = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';
    private $ExtNs = 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2';
    private $DsNs = 'http://www.w3.org/2000/09/xmldsig#';

    public function assertSchema($xml)
    {
        $doc = $this->getDocument($xml);
        $version = $this->getUblVersion($doc);
        if ($version === '2.1') {
            $this->createExtensionContent($doc);
            $xml = $doc->saveXML();
        }

        $validator = $this->getValidator($version);

        $success = $validator->validate($xml);

        if ($success === false) {
            echo $validator->getMessage().PHP_EOL;
        }

        $this->assertTrue($success);
    }

    private function getDocument($xml)
    {
        if ($xml instanceof \DOMDocument) {
            return $xml;
        }

        $doc = new \DOMDocument();
        $doc->loadXML($xml);

        return $doc;
    }

    private function createExtensionContent(\DOMDocument $document)
    {
        $childs = $document->documentElement->getElementsByTagNameNS('urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2','ExtensionContent');
        if ($childs->length > 0) {
            $element = $document->createElementNS('urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2','cbc:AccountID', 1);
            $childs->item(0)->appendChild($element);
        }
    }

    public function getFillSignNode(\DOMDocument $doc)
    {
        $items = $doc->getElementsByTagNameNS($this->ExtNs,'ExtensionContent');

        if ($items->length === 0) {
            return $doc->saveXML();
        }

        $node = $doc->createElementNS($this->DsNs,'Signature');
        $signInfo = $doc->createElementNS($this->DsNs,'SignedInfo');
        $can = $doc->createElementNS($this->DsNs,'CanonicalizationMethod');
        $can->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        $sigMet = $doc->createElementNS($this->DsNs,'SignatureMethod');
        $sigMet->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        $tran = $doc->createElementNS($this->DsNs, 'Transform');
        $tran->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        $tranf = $doc->createElementNS($this->DsNs, 'Transforms');
        $tranf->appendChild($tran);
        $ref = $doc->createElementNS($this->DsNs,'Reference');
        $digMet = $doc->createElementNS($this->DsNs,'DigestMethod');
        $digMet->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
        $ref->appendChild($tranf);
        $ref->appendChild($digMet);
        $ref->appendChild($doc->createElementNS($this->DsNs, 'DigestValue'));
        $signInfo->appendChild($can);
        $signInfo->appendChild($sigMet);
        $signInfo->appendChild($ref);

        $node->appendChild($signInfo);
        $node->appendChild($doc->createElementNS($this->DsNs,'SignatureValue'));

        $items->item(0)->appendChild($node);
        return $doc->saveXML();
    }

    /**
     * @param string $version
     * @return SchemaValidatorInterface
     */
    private function getValidator($version = '2.0')
    {
        $validator = new SchemaValidator();
        $validator->setVersion($version);

        return $validator;
    }

    private function getUblVersion(\DOMDocument $doc)
    {
        $items = $doc->getElementsByTagNameNS($this->CbcNs,'UBLVersionID');

        return $items->length === 0 ? '2.0' : $items->item(0)->textContent;
    }
}
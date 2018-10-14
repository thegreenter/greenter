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

    public function assertSchema($xml)
    {
        $version = $this->getUblVersion($xml);
        if ($version === '2.1') {
            $xml = $this->getFillSignNode($xml);
        }

        $validator = $this->getValidator($version);

        $success = $validator->validate($xml);

        if ($success === false) {
            echo $validator->getMessage().PHP_EOL;
        }

        $this->assertTrue($success);
    }

    public function getFillSignNode($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $items = $doc->getElementsByTagNameNS($this->ExtNs,'ExtensionContent');

        if ($items->length === 0) {
            return $xml;
        }

        $node = $doc->createElement('sign', '');
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

    private function getUblVersion($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $items = $doc->getElementsByTagNameNS($this->CbcNs,'UBLVersionID');

        return $items->length === 0 ? '2.0' : $items->item(0)->textContent;
    }
}
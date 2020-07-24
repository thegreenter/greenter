<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 24/01/2018
 * Time: 10:14 AM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use Greenter\Ubl\Resolver\UblPathResolver;
use Greenter\Ubl\UblValidator;
use Greenter\Ubl\UblValidatorInterface;

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
        $success = $validator->isValid($xml);

        if ($success === false) {
            echo $validator->getError().PHP_EOL;
        }

        $this->assertTrue($success);
    }

    private function getDocument($xml)
    {
        if ($xml instanceof DOMDocument) {
            return $xml;
        }

        $doc = new DOMDocument();
        $doc->loadXML($xml);

        return $doc;
    }

    private function createExtensionContent(DOMDocument $document)
    {
        $childs = $document->documentElement->getElementsByTagNameNS('urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2', 'ExtensionContent');
        if ($childs->length > 0) {
            $element = $document->createElementNS('urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2', 'cbc:AccountID', '1');
            $childs->item(0)->appendChild($element);
        }
    }

    /**
     * @param string $version
     * @return UblValidatorInterface
     */
    private function getValidator($version)
    {
        $validator = new UblValidator();
        $validator->pathResolver = new UblPathResolver();
        $validator->pathResolver->version = $version;

        return $validator;
    }

    private function getUblVersion(DOMDocument $doc)
    {
        $items = $doc->getElementsByTagNameNS($this->CbcNs, 'UBLVersionID');

        return $items->length === 0 ? '2.0' : $items->item(0)->textContent;
    }
}

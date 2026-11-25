<?php

declare(strict_types=1);

namespace Greenter\Processor;

use Greenter\XMLSecLibs\Sunat\SignedXml;

/**
 * Firma con `greenter/xmldsig` (SignedXml).
 */
final class SignedXmlSigner implements XmlSignerInterface
{
    private SignedXml $signer;

    public function __construct(SignedXml $signer)
    {
        $this->signer = $signer;
    }

    /**
     * Crea el firmador con el certificado (PEM con la clave privada y el certificado).
     */
    public static function fromCertificate(string $certificate): self
    {
        $signer = new SignedXml();
        $signer->setCertificate($certificate);

        return new self($signer);
    }

    public function signXml(string $xml): string
    {
        return (string)$this->signer->signXml($xml);
    }
}

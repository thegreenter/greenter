<?php

declare(strict_types=1);

namespace Greenter\Processor;

/**
 * Firma digital del XML de un comprobante.
 */
interface XmlSignerInterface
{
    /**
     * @param string $xml XML sin firmar
     *
     * @return string XML firmado
     */
    public function signXml(string $xml): string;
}

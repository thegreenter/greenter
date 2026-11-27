<?php

declare(strict_types=1);

namespace Greenter\Processor;

use Greenter\Exception\GreenterException;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;

/**
 * Genera, firma y envía comprobantes: construir XML => firmar => enviar.
 *
 * Sus dependencias se reciben en el constructor y no cambian (sin estado entre envíos),
 * una misma instancia se puede compartir entre documentos.
 *
 * Errores: los de negocio (rechazos de SUNAT, SoapFault) se informan en el resultado;
 * los técnicos lanzan una excepción que implementa GreenterException.
 */
final class DocumentProcessor
{
    private BuilderResolverInterface $builders;
    private XmlSignerInterface $signer;
    private SenderResolverInterface $senders;

    public function __construct(
        BuilderResolverInterface $builders,
        XmlSignerInterface $signer,
        SenderResolverInterface $senders
    ) {
        $this->builders = $builders;
        $this->signer = $signer;
        $this->senders = $senders;
    }

    /**
     * Genera el XML sin firmar.
     *
     * @throws GreenterException
     */
    public function build(DocumentInterface $document): string
    {
        $builder = $this->builders->find(get_class($document));

        return (string)$builder->build($document);
    }

    /**
     * Genera y firma el XML.
     *
     * @throws GreenterException
     */
    public function getXmlSigned(DocumentInterface $document): string
    {
        return $this->signer->signXml($this->build($document));
    }

    /**
     * Genera, firma y envía el documento.
     *
     * Para conservar el XML firmado usar `getXmlSigned()` y luego `sendXml()`.
     *
     * @throws GreenterException
     */
    public function send(DocumentInterface $document): ?BaseResult
    {
        return $this->sendXml(get_class($document), $document->getName(), $this->getXmlSigned($document));
    }

    /**
     * Envía un XML firmado.
     *
     * @param string $docClass Clase del documento, determina el servicio de envío
     * @param string $name     Nombre del archivo sin extensión
     * @param string $xml      XML firmado
     */
    public function sendXml(string $docClass, string $name, string $xml): ?BaseResult
    {
        return $this->senders->find($docClass)->send($name, $xml);
    }
}

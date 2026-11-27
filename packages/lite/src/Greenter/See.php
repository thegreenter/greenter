<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/10/2017
 * Time: 04:23 PM.
 */

declare(strict_types=1);

namespace Greenter;

use DOMDocument;
use Exception;
use Greenter\Factory\FeFactory;
use Greenter\Factory\WsSenderResolver;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Processor\DocumentProcessor;
use Greenter\Processor\SignedXmlSigner;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Builder\DocumentNoSupportException;
use Greenter\Ws\Reader\XmlFilenameExtractor;
use Greenter\Ws\Reader\XmlReader;
use Greenter\Ws\Reader\XmlReaderException;
use Greenter\Ws\Resolver\XmlTypeResolver;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\SoapClient;
use Greenter\XMLSecLibs\Sunat\SignedXml;

/**
 * Sistema de Emision del Contribuyente.
 *
 * Fachada sobre DocumentProcessor (construir XML => firmar => enviar) para los servicios SOAP de SUNAT.
 *
 * Class See
 */
class See
{
    /**
     * @var FeFactory
     */
    private $factory;

    /**
     * @var SoapClient
     */
    private $wsClient;

    /**
     * @var SignedXml
     */
    private $signer;

    /**
     * @var ErrorCodeProviderInterface|null
     */
    private $codeProvider;

    /**
     * Twig Render Options.
     *
     * @var array
     */
    private $options = ['autoescape' => 'html'];

    /**
     * @var XmlBuilderResolver|null
     */
    private $builderResolver;

    /**
     * @var WsSenderResolver|null
     */
    private $senderResolver;

    /**
     * @var DocumentProcessor|null
     */
    private $processor;

    /**
     * Ultimo xml firmado.
     *
     * @var string|null
     */
    private $lastXml;

    /**
     * See constructor.
     *
     * @param SoapClient|null $wsClient Cliente SOAP, ejm: `SoapClient::createSecure()` para verificar el certificado TLS de SUNAT.
     * @param SignedXml|null  $signer   Firmador XML
     */
    public function __construct(?SoapClient $wsClient = null, ?SignedXml $signer = null)
    {
        $this->factory = new FeFactory();
        $this->wsClient = $wsClient ?? new SoapClient();
        $this->signer = $signer ?? new SignedXml();
        $this->factory->setSigner($this->signer);
    }

    /**
     * Set Xml Builder Options.
     *
     * @param array $options
     */
    public function setBuilderOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        $this->getBuilderResolver()->setOptions($this->options);
    }

    /**
     * @param string $directory
     */
    public function setCachePath(?string $directory)
    {
        $this->options['cache'] = empty($directory) ? false : $directory;
        $this->getBuilderResolver()->setOptions($this->options);
    }

    /**
     * @param string $certificate
     */
    public function setCertificate(string $certificate)
    {
        $this->signer->setCertificate($certificate);
    }

    /**
     * @param string $user
     * @param string $password
     */
    public function setCredentials(string $user, string $password)
    {
        $this->wsClient->setCredentials($user, $password);
    }

    /**
     * Set Clave SOL de usuario secundario.
     *
     * @param string $ruc
     * @param string $user
     * @param string $password
     */
    public function setClaveSOL(string $ruc, string $user, string $password)
    {
        $this->wsClient->setCredentials($ruc.$user, $password);
    }

    /**
     * @param string $service
     */
    public function setService(?string $service)
    {
        $this->wsClient->setService($service);
    }

    /**
     * Set error code provider.
     *
     * @param ErrorCodeProviderInterface|null $codeProvider
     */
    public function setCodeProvider(?ErrorCodeProviderInterface $codeProvider)
    {
        $this->codeProvider = $codeProvider;
        $this->senderResolver = null;
        $this->processor = null;
    }

    /**
     * Get signed xml from document.
     *
     * @param DocumentInterface $document
     *
     * @return null|string
     */
    public function getXmlSigned(DocumentInterface $document): ?string
    {
        $docClass = get_class($document);
        $this->lastXml = $this->getProcessor()->getXmlSigned($document);

        $this->factory
            ->setBuilder($this->getBuilderResolver()->find($docClass))
            ->setLastXml($this->lastXml);

        return $this->lastXml;
    }

    /**
     * Envia documento.
     *
     * @param DocumentInterface $document
     *
     * @return BaseResult|null
     */
    public function send(DocumentInterface $document): ?BaseResult
    {
        $xml = (string)$this->getXmlSigned($document);

        return $this->sendXml(get_class($document), $document->getName(), $xml);
    }

    /**
     * Envia xml generado.
     *
     * @param string $type Document Type
     * @param string $name Xml Name
     * @param string $xml  Xml Content
     *
     * @return BaseResult|null
     */
    public function sendXml(string $type, string $name, string $xml): ?BaseResult
    {
        // Valida el tipo de documento (DocumentNoSupportException si no está soportado)
        $this->factory
            ->setBuilder($this->getBuilderResolver()->find($type))
            ->setSender($this->getSenderResolver()->find($type));

        return $this->getProcessor()->sendXml($type, $name, $xml);
    }

    /**
     * Envia XML generado previamente.
     *
     * @param string $xmlContent
     *
     * @return BaseResult|null
     *
     * @throws XmlReaderException          Si el contenido no es un XML válido
     * @throws DocumentNoSupportException  Si el XML no es un comprobante soportado
     * @throws Exception
     */
    public function sendXmlFile(string $xmlContent): ?BaseResult
    {
        $doc = new DOMDocument();
        if (trim($xmlContent) === '' || !@$doc->loadXML($xmlContent)) {
            throw new XmlReaderException('El contenido no es un XML válido.');
        }

        $reader = new XmlReader();
        $resolver = new XmlTypeResolver($reader);
        $type = $resolver->getType($doc);
        if (empty($type)) {
            throw new DocumentNoSupportException('Tipo de comprobante no soportado: '.$doc->documentElement->localName);
        }

        $extractor = new XmlFilenameExtractor($reader);
        $name = $extractor->getFilename($doc);

        return $this->sendXml($type, $name, $xmlContent);
    }

    /**
     * @param string|null $ticket
     *
     * @return StatusResult
     * @throws Exception
     */
    public function getStatus(?string $ticket): StatusResult
    {
        $sender = new ExtService();
        $sender->setClient($this->wsClient);

        return $sender->getStatus($ticket);
    }

    /**
     * Ultimo XML firmado (getXmlSigned o send).
     *
     * @return string|null
     */
    public function getLastXml(): ?string
    {
        return $this->lastXml;
    }

    /**
     * @return FeFactory
     *
     * @deprecated desde 5.5, se elimina en 6.0. Usar `See::getLastXml()` para el último XML firmado
     *             y `See::getProcessor()` (DocumentProcessor) para construir, firmar y enviar.
     */
    public function getFactory(): FeFactory
    {
        @trigger_error(sprintf('"%s()" está deprecado desde greenter/lite 5.5 y se elimina en 6.0, usar "%s::getLastXml()" o "%s::getProcessor()".', __METHOD__, self::class, self::class), E_USER_DEPRECATED);

        return $this->factory;
    }

    /**
     * Procesador de documentos (construir XML => firmar => enviar) con la configuración actual.
     *
     * @return DocumentProcessor
     */
    public function getProcessor(): DocumentProcessor
    {
        if ($this->processor === null) {
            $this->processor = new DocumentProcessor(
                $this->getBuilderResolver(),
                new SignedXmlSigner($this->signer),
                $this->getSenderResolver()
            );
        }

        return $this->processor;
    }

    /**
     * Resolver de XML builders, permite registrar builders para documentos propios.
     *
     * Los builders se reutilizan entre envíos (y con ellos el entorno Twig).
     *
     * @return XmlBuilderResolver
     */
    public function getBuilderResolver(): XmlBuilderResolver
    {
        if ($this->builderResolver === null) {
            $this->builderResolver = new XmlBuilderResolver($this->options);
        }

        return $this->builderResolver;
    }

    private function getSenderResolver(): WsSenderResolver
    {
        if ($this->senderResolver === null) {
            $this->senderResolver = new WsSenderResolver($this->wsClient, $this->codeProvider);
        }

        return $this->senderResolver;
    }
}

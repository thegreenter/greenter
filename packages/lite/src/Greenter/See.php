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
use Greenter\Model\Response\StatusResult;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Reader\XmlFilenameExtractor;
use Greenter\Ws\Reader\XmlReader;
use Greenter\Ws\Resolver\XmlTypeResolver;
use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\SoapClient;
use Greenter\XMLSecLibs\Sunat\SignedXml;

/**
 * Sistema de Emision del Contribuyente.
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
    private $options = ['autoescape' => false];

    /**
     * See constructor.
     */
    public function __construct()
    {
        $this->factory = new FeFactory();
        $this->wsClient = new SoapClient();
        $this->signer = new SignedXml();
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
    }

    /**
     * @param string $directory
     */
    public function setCachePath(?string $directory)
    {
        $this->options['cache'] = empty($directory) ? false : $directory;
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
        $buildResolver = new XmlBuilderResolver($this->options);

        return $this->factory
            ->setBuilder($buildResolver->find(get_class($document)))
            ->getXmlSigned($document);
    }

    /**
     * Envia documento.
     *
     * @param DocumentInterface $document
     *
     * @return Model\Response\BaseResult|null
     */
    public function send(DocumentInterface $document): ?Model\Response\BaseResult
    {
        $this->configureFactory(get_class($document));

        return $this->factory->send($document);
    }

    /**
     * Envia xml generado.
     *
     * @param string $type Document Type
     * @param string $name Xml Name
     * @param string $xml  Xml Content
     *
     * @return Model\Response\BaseResult|null
     */
    public function sendXml(string $type, string $name, string $xml): ?Model\Response\BaseResult
    {
        $this->configureFactory($type);

        return $this->factory->sendXml($name, $xml);
    }

    /**
     * Envia XML generado previamente.
     *
     * @param string $xmlContent
     *
     * @return Model\Response\BaseResult|null
     *
     * @throws Exception
     */
    public function sendXmlFile(string $xmlContent): ?Model\Response\BaseResult
    {
        $doc = new DOMDocument();
        $doc->loadXML($xmlContent);

        $reader = new XmlReader();
        $resolver = new XmlTypeResolver($reader);
        $type = $resolver->getType($doc);

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
     * @return FeFactory
     */
    public function getFactory(): FeFactory
    {
        return $this->factory;
    }

    private function configureFactory(string $docClass): void
    {
        $buildResolver = new XmlBuilderResolver($this->options);
        $senderResolver = new WsSenderResolver($this->wsClient, $this->codeProvider);

        $this->factory
            ->setBuilder($buildResolver->find($docClass))
            ->setSender($senderResolver->find($docClass));
    }
}

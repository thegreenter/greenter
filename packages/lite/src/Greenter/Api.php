<?php

declare(strict_types=1);

namespace Greenter;

use Greenter\Api\ApiFactory;
use Greenter\Api\GreSender;
use Greenter\Api\InMemoryStore;
use Greenter\Factory\GreSenderResolver;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Processor\DocumentProcessor;
use Greenter\Processor\SignedXmlSigner;
use Greenter\Sunat\GRE\Api\AuthApi;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Configuration;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use GuzzleHttp\Client;

class Api
{
    private ApiFactory $factory;
    private SignedXml $signer;
    private ?string $lastXml = null;
    private ?XmlBuilderResolver $builderResolver = null;
    private ?DocumentProcessor $processor = null;

    private array $credentials = [];
    private array $defaultEndpoints = [
        'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
        'cpe' => 'https://api-cpe.sunat.gob.pe/v1',
    ];

    /**
     * Twig Render Options.
     */
    private array $options = ['autoescape' => 'html'];

    /**
     * @param array|null $endpoints
     * @param ApiFactory|null $factory
     * @param SignedXml|null $signer
     */
    public function __construct(?array $endpoints = null, ?ApiFactory $factory = null, ?SignedXml $signer = null)
    {
        $this->factory = $factory ?? $this->createApiFactory($endpoints ?? $this->defaultEndpoints);
        $this->signer = $signer ?? new SignedXml();
    }

    /**
     * Set Xml Builder Options.
     *
     * @param array $options
     *
     * @return Api
     */
    public function setBuilderOptions(array $options): Api
    {
        $this->options = array_merge($this->options, $options);
        $this->getBuilderResolver()->setOptions($this->options);

        return $this;
    }

    /**
     * @param string $clientId
     * @param string $secret
     *
     * @return Api
     */
    public function setApiCredentials(string $clientId, string $secret): Api
    {
        $this->credentials['client_id'] = $clientId;
        $this->credentials['client_secret'] = $secret;
        $this->processor = null;

        return $this;
    }

    /**
     * Set Clave SOL de usuario secundario.
     *
     * @param string $ruc
     * @param string $user
     * @param string $password
     *
     * @return Api
     */
    public function setClaveSOL(string $ruc, string $user, string $password): Api
    {
        $this->credentials['username'] = $ruc.$user;
        $this->credentials['password'] = $password;
        $this->processor = null;

        return $this;
    }

    /**
     * @param string $certificate
     *
     * @return Api
     */
    public function setCertificate(string $certificate): Api
    {
        $this->signer->setCertificate($certificate);

        return $this;
    }

    /**
     * Get Last XML Signed.
     *
     * @return string
     */
    public function getLastXml(): ?string
    {
        return $this->lastXml;
    }

    /**
     * Envia comprobante.
     *
     * @param DocumentInterface $document
     *
     * @return BaseResult|null
     * @throws ApiException
     */
    public function send(DocumentInterface $document): ?BaseResult
    {
        $processor = $this->getProcessor();
        $this->lastXml = $processor->getXmlSigned($document);

        return $processor->sendXml(get_class($document), $document->getName(), $this->lastXml);
    }

    /**
     * Enviar xml firmado.
     *
     * @param string $name
     * @param string $content
     * @return BaseResult|null
     * @throws ApiException
     */
    public function sendXml(string $name, string $content): ?BaseResult
    {
        return $this->getProcessor()->sendXml(Despatch::class, $name, $content);
    }

    /**
     * Consultar el estado del envio.
     *
     * @param string|null $ticket
     * @return StatusResult
     * @throws ApiException
     */
    public function getStatus(?string $ticket): StatusResult
    {
        $sender = $this->createSender();

        return $sender->status($ticket);
    }

    /**
     * Resolver de XML builders, permite registrar builders para documentos propios.
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
                $this->createSenderResolver()
            );
        }

        return $this->processor;
    }

    private function createSenderResolver(): GreSenderResolver
    {
        return new GreSenderResolver($this->factory, $this->credentials);
    }

    /**
     * @throws ApiException
     */
    private function createSender(): GreSender
    {
        /** @var GreSender */
        return $this->createSenderResolver()->find(Despatch::class);
    }

    private function createApiFactory(array $endpoints): ApiFactory
    {
        $client = new Client();
        $config = new Configuration();

        return new ApiFactory(
            new AuthApi($client, $config->setHost($endpoints['auth'])),
            $client,
            new InMemoryStore(),
            $endpoints['cpe'],
        );
    }
}

<?php

declare(strict_types=1);

namespace Greenter;

use Greenter\Api\ApiFactory;
use Greenter\Api\GreSender;
use Greenter\Api\InMemoryStore;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Services\Api\TokenStoreInterface;
use Greenter\Sunat\GRE\Api\AuthApi;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Configuration;
use Greenter\XMLSecLibs\Sunat\SignedXml;
use GuzzleHttp\Client;
use LogicException;

class Api
{
    private ?ApiFactory $factory = null;
    private bool $customFactory;
    private array $endpoints;
    private ?TokenStoreInterface $tokenStore = null;
    private ?SignedXml $signer = null;
    private ?string $lastXml = null;

    private array $credentials = [];
    private array $defaultEndpoints = [
        'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
        'cpe' => 'https://api-cpe.sunat.gob.pe/v1',
    ];

    /**
     * Twig Render Options.
     */
    private array $options = ['autoescape' => false];

    /**
     * @param array|null $endpoints
     * @param ApiFactory|null $factory
     * @param SignedXml|null $signer
     */
    public function __construct(?array $endpoints = null, ?ApiFactory $factory = null, ?SignedXml $signer = null)
    {
        $this->endpoints = $endpoints ?? $this->defaultEndpoints;
        $this->factory = $factory;
        $this->customFactory = $factory !== null;
        $this->signer = $signer ?? new SignedXml();
    }

    /**
     * Establece donde se guarda el token de acceso de la API (por defecto en memoria).
     *
     * Usar un almacenamiento persistente (ej. FileTokenStore, Psr16TokenStore) evita
     * solicitar un nuevo token a SUNAT en cada petición/proceso.
     *
     * @param TokenStoreInterface $store
     *
     * @return Api
     */
    public function setTokenStore(TokenStoreInterface $store): Api
    {
        if ($this->customFactory) {
            throw new LogicException('Se inyectó un ApiFactory personalizado; configure el TokenStore en ese ApiFactory.');
        }

        $this->tokenStore = $store;
        $this->factory = null;

        return $this;
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
        $buildResolver = new XmlBuilderResolver($this->options);
        $builder = $buildResolver->find(get_class($document));

        $xml = $builder->build($document);
        $this->lastXml = $this->signer->signXml($xml);
        return $this->sendXml($document->getName(), $this->lastXml);
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
        $sender = $this->createSender();

        return $sender->send($name, $content);
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
     * @throws ApiException
     */
    private function createSender(): GreSender
    {
        $api = $this->getFactory()->create(
            $this->credentials['client_id'],
            $this->credentials['client_secret'],
            $this->credentials['username'],
            $this->credentials['password']
        );

        return new GreSender($api);
    }

    private function getFactory(): ApiFactory
    {
        if ($this->factory === null) {
            $this->factory = $this->createApiFactory($this->endpoints);
        }

        return $this->factory;
    }

    private function createApiFactory(array $endpoints): ApiFactory
    {
        $client = new Client();
        $config = new Configuration();

        return new ApiFactory(
            new AuthApi($client, $config->setHost($endpoints['auth'])),
            $client,
            $this->tokenStore ?? new InMemoryStore(),
            $endpoints['cpe'],
        );
    }
}

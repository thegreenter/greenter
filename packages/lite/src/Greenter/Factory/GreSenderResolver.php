<?php

declare(strict_types=1);

namespace Greenter\Factory;

use Greenter\Api\ApiFactory;
use Greenter\Api\GreSender;
use Greenter\Processor\SenderResolverInterface;
use Greenter\Services\SenderInterface;
use Greenter\Sunat\GRE\ApiException;

/**
 * Servicio de envío del API REST de SUNAT (guía de remisión electrónica).
 */
final class GreSenderResolver implements SenderResolverInterface
{
    private ApiFactory $factory;
    private array $credentials;

    /**
     * @param ApiFactory $factory
     * @param array $credentials client_id, client_secret, username y password
     */
    public function __construct(ApiFactory $factory, array $credentials)
    {
        $this->factory = $factory;
        $this->credentials = $credentials;
    }

    /**
     * @return GreSender
     *
     * @throws ApiException Si no se obtiene el token de acceso
     */
    public function find(string $docClass): SenderInterface
    {
        $api = $this->factory->create(
            $this->credentials['client_id'] ?? null,
            $this->credentials['client_secret'] ?? null,
            $this->credentials['username'] ?? null,
            $this->credentials['password'] ?? null
        );

        return new GreSender($api);
    }
}

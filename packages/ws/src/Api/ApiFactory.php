<?php

declare(strict_types=1);

namespace Greenter\Api;

use DateInterval;
use DateTime;
use Exception;
use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;
use Greenter\Sunat\GRE\Api\AuthApiInterface;
use Greenter\Sunat\GRE\Api\CpeApi;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Configuration;
use GuzzleHttp\ClientInterface;

class ApiFactory
{
    private AuthApiInterface $api;
    private ClientInterface $client;
    private TokenStoreInterface $store;
    private ?string $cpeEndpoint;

    /**
     * @param AuthApiInterface $api
     * @param ClientInterface $client
     * @param TokenStoreInterface $store
     * @param string|null $endpoint
     */
    public function __construct(
        AuthApiInterface $api,
        ClientInterface $client,
        TokenStoreInterface $store,
        ?string $endpoint)
    {
        $this->api = $api;
        $this->client = $client;
        $this->store = $store;
        $this->cpeEndpoint = $endpoint;
    }

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function create(?string $client_id, ?string $secret, ?string $user, ?string $password): CpeApi
    {
        $tokenData = $this->store->get($client_id);
        if ($tokenData && $tokenData->getExpire() > $this->addSeconds(new DateTime(), 600)) {
            $token = $tokenData->getValue();
        } else {
            $result = $this->api->getToken(
                'password',
                'https://api-cpe.sunat.gob.pe',
                $client_id,
                $secret,
                $user,
                $password);

            $token = $result->getAccessToken();
            $expire =  $this->addSeconds(new DateTime(), $result->getExpiresIn());
            $this->store->set($client_id, new BasicToken($token, $expire));
        }

        $config = Configuration::getDefaultConfiguration()
            ->setAccessToken($token);

        return new CpeApi(
            $this->client,
            $config->setHost($this->cpeEndpoint ?? $config->getHostFromSettings(1))
        );
    }

    /**
     * @throws Exception
     */
    private function addSeconds(DateTime $time, int $seconds): DateTime {
        return $time->add(new DateInterval('PT'.$seconds.'S'));
    }
}

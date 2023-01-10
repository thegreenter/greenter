<?php

namespace Greenter\Api;

use DateInterval;
use DateTime;
use Exception;
use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;
use Greenter\Sunat\GRE\Api\AuthApi;
use Greenter\Sunat\GRE\Api\CpeApi;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Configuration;
use GuzzleHttp\Client;

class ApiFactory
{
    private AuthApi $api;
    private Client $client;
    private TokenStoreInterface $store;

    /**
     * @param AuthApi $api
     * @param Client $client
     * @param TokenStoreInterface $store
     */
    public function __construct(AuthApi $api, Client $client, TokenStoreInterface $store)
    {
        $this->api = $api;
        $this->client = $client;
        $this->store = $store;
    }

    /**
     * @throws ApiException
     * @throws Exception
     */
    public function create(?string $client_id, ?string $secret, ?string $user, ?string $password): CpeApi
    {
        $token = '';
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
            $config->setHost($config->getHostFromSettings(1))
        );
    }

    /**
     * @throws Exception
     */
    function addSeconds(DateTime $time, int $seconds): DateTime {
        return $time->add(new DateInterval('PT'.$seconds.'S'));
    }
}
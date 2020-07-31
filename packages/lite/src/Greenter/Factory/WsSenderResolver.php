<?php

declare(strict_types=1);

namespace Greenter\Factory;

use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Services\SenderInterface;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\WsClientInterface;

class WsSenderResolver
{
    /**
     * @var string[]
     */
    private $summary;
    /**
     * @var WsClientInterface
     */
    private $client;
    /**
     * @var ErrorCodeProviderInterface|null
     */
    private $codeProvider;

    /**
     * WsSenderResolver constructor.
     * @param WsClientInterface $client
     * @param ErrorCodeProviderInterface|null $codeProvider
     */
    public function __construct(WsClientInterface $client, ?ErrorCodeProviderInterface $codeProvider)
    {
        $this->client = $client;
        $this->codeProvider = $codeProvider;
        $this->summary = [
            Summary::class,
            Voided::class,
            Reversion::class
        ];
    }

    public function find(string $docClass): SenderInterface
    {
        $sender = in_array($docClass, $this->summary) ? new SummarySender() : new BillSender();
        $sender->setClient($this->client);
        $sender->setCodeProvider($this->codeProvider);

        return $sender;
    }
}

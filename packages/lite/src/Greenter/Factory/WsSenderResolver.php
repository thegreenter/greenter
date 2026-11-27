<?php

declare(strict_types=1);

namespace Greenter\Factory;

use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Processor\SenderResolverInterface;
use Greenter\Services\SenderInterface;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Services\BillSender;
use Greenter\Ws\Services\SummarySender;
use Greenter\Ws\Services\WsClientInterface;

/**
 * Servicio de envío SOAP de SUNAT: sendSummary (ticket) para resumen diario, comunicación de
 * baja y reversión; sendBill para los demás comprobantes.
 */
class WsSenderResolver implements SenderResolverInterface
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
     * @var array<string, SenderInterface>
     */
    private $senders = [];

    /**
     * WsSenderResolver constructor.
     * @param WsClientInterface $client
     * @param ErrorCodeProviderInterface|null $codeProvider
     */
    public function __construct(WsClientInterface $client, ?ErrorCodeProviderInterface $codeProvider = null)
    {
        $this->client = $client;
        $this->codeProvider = $codeProvider;
        $this->summary = [
            Summary::class,
            Voided::class,
            Reversion::class
        ];
    }

    /**
     * Los servicios se reutilizan entre envíos (comparten el cliente SOAP).
     */
    public function find(string $docClass): SenderInterface
    {
        $senderClass = $this->isSummary($docClass) ? SummarySender::class : BillSender::class;
        if (!isset($this->senders[$senderClass])) {
            $sender = new $senderClass();
            $sender->setClient($this->client);
            $sender->setCodeProvider($this->codeProvider);
            $this->senders[$senderClass] = $sender;
        }

        return $this->senders[$senderClass];
    }

    /**
     * Documentos de envío asíncrono (ticket), incluye sus subclases.
     */
    private function isSummary(string $docClass): bool
    {
        foreach ($this->summary as $summaryClass) {
            if (is_a($docClass, $summaryClass, true)) {
                return true;
            }
        }

        return false;
    }
}

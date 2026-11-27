<?php

declare(strict_types=1);

namespace Tests\Greenter\Processor;

use Greenter\Factory\XmlBuilderResolver;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Processor\DocumentProcessor;
use Greenter\Processor\SenderResolverInterface;
use Greenter\Processor\SignedXmlSigner;
use Greenter\Services\SenderInterface;
use Greenter\XMLSecLibs\Sunat\SignedXml;

/**
 * Procesa documentos con DocumentProcessor y un servicio de envío fijo.
 */
trait ProcessorTestTrait
{
    /**
     * Ultimo XML firmado.
     *
     * @var string|null
     */
    protected $lastXml;

    protected function createProcessor(SenderInterface $sender, array $options = ['cache' => false, 'strict_variables' => true]): DocumentProcessor
    {
        $signer = new SignedXml();
        $signer->setCertificateFromFile(__DIR__.'/../../Resources/SFSCert.pem');

        $senders = new class($sender) implements SenderResolverInterface {
            private SenderInterface $sender;

            public function __construct(SenderInterface $sender)
            {
                $this->sender = $sender;
            }

            public function find(string $docClass): SenderInterface
            {
                return $this->sender;
            }
        };

        return new DocumentProcessor(
            new XmlBuilderResolver($options),
            new SignedXmlSigner($signer),
            $senders
        );
    }

    protected function process(DocumentInterface $document, SenderInterface $sender, array $options = ['cache' => false, 'strict_variables' => true]): ?BaseResult
    {
        $processor = $this->createProcessor($sender, $options);
        $this->lastXml = $processor->getXmlSigned($document);

        return $processor->sendXml(get_class($document), $document->getName(), $this->lastXml);
    }
}

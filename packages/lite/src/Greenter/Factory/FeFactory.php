<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter\Factory;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Services\SenderInterface;
use RobRichards\XMLSecLibs\Sunat\Adapter\SunatXmlSecAdapter;

/**
 * Class FeFactory
 * @package Greenter\Factory
 */
class FeFactory implements FactoryInterface
{
    /**
     * @var SunatXmlSecAdapter
     */
    private $signer;

    /**
     * Sender service.
     *
     * @var SenderInterface
     */
    private $sender;

    /**
     * Ultimo xml generado.
     *
     * @var string
     */
    private $lastXml;

    /**
     * Xml Builder.
     *
     * @var BuilderInterface
     */
    private $builder;

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->signer = new SunatXmlSecAdapter();
    }

    /**
     * Get document builder.
     *
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Get sender service.
     *
     * @return SenderInterface
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set sender service.
     *
     * @param SenderInterface $sender
     * @return FeFactory
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * Set document builder.
     *
     * @param BuilderInterface $builder
     * @return FeFactory
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * Build and send document.
     *
     * @param DocumentInterface $document
     * @return BaseResult
     */
    public function send(DocumentInterface $document)
    {
        $xml = $this->builder->build($document);
        $this->lastXml = $this->getXmmlSigned($xml);

        return $this->sender->send($document->getName(), $this->lastXml);
    }

    /**
     * Set Certicated content (From PEM format)
     *
     * @param string $cert
     */
    public function setCertificate($cert)
    {
        $this->signer->setCertificate($cert);
    }

    /**
     * Get Last XML Signed.
     *
     * @return string
     */
    public function getLastXml()
    {
        return $this->lastXml;
    }

    /**
     * @param string $xml
     * @return string
     */
    private function getXmmlSigned($xml)
    {
        return $this->signer->signXml($xml);
    }
}
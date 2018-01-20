<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM.
 */

namespace Greenter\Factory;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Services\SenderInterface;
use Greenter\XMLSecLibs\Sunat\AdapterInterface;
use Greenter\XMLSecLibs\Sunat\SunatXmlSecAdapter;

/**
 * Class FeFactory.
 */
class FeFactory implements FactoryInterface
{
    /**
     * @var AdapterInterface
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
     *
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
     *
     * @return FeFactory
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @return AdapterInterface
     */
    public function getSigner()
    {
        return $this->signer;
    }

    /**
     * @param AdapterInterface $signer
     *
     * @return FeFactory
     */
    public function setSigner($signer)
    {
        $this->signer = $signer;

        return $this;
    }

    /**
     * Build and send document.
     *
     * @param DocumentInterface $document
     *
     * @return BaseResult
     */
    public function send(DocumentInterface $document)
    {
        $this->lastXml = $this->getXmmlSigned($document);

        return $this->sender->send($document->getName(), $this->lastXml);
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
     * @param DocumentInterface $document
     *
     * @return string
     */
    public function getXmmlSigned(DocumentInterface $document)
    {
        $xml = $this->builder->build($document);

        return $this->signer->signXml($xml);
    }
}

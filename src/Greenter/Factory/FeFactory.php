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
use Greenter\Validator\DocumentValidatorInterface;
use Greenter\Validator\ValidationException;
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
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var DocumentValidatorInterface
     */
    private $validator;

    /**
     * @param $validator
     * @return FeFactory
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->signer = new SunatXmlSecAdapter();
    }

    /**
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @return SenderInterface
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param SenderInterface $sender
     * @return FeFactory
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @param BuilderInterface $builder
     * @return FeFactory
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * @param DocumentInterface $document
     * @return BaseResult
     * @throws ValidationException
     */
    public function send(DocumentInterface $document)
    {
        $this->validate($document);
        $xml = $this->builder->build($document);
        $this->lastXml = $this->getXmmlSigned($xml);

        return $this->sender->send($document->getName(), $this->lastXml);
    }

    /**
     * Set Certicated content
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

    private function validate(DocumentInterface $document)
    {
        if (!$this->validator) {
            return;
        }
        $errs = $this->validator->validate($document);
        if (count($errs) > 0) {
            throw new ValidationException($errs);
        }
    }
}
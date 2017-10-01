<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter\Factory;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Xml\Builder\BuilderInterface;

/**
 * Class FeFactory
 * @package Greenter\Factory
 */
class FeFactory extends BaseFactory implements FactoryInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
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
     * @return BillResult
     */
    public function sendDocument(DocumentInterface $document)
    {
        $xml = $this->builder->build($document);

        return $this->getBillResult($xml,$document->getName());
    }

    /**
     * @param DocumentInterface $document
     * @return SummaryResult
     */
    public function sendSummary(DocumentInterface $document)
    {
        $xml = $this->builder->build($document);

        return $this->getSummaryResult($xml,$document->getName());
    }

    /**
     * Get Status by Ticket.
     *
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket)
    {
        return $this->sender->getStatus($ticket);
    }

    /**
     * @param array $params
     */
    public function setParameters($params)
    {
        $this->setWsParams($params['ws']);
        if (isset($params['cert'])) {
            $this->signer->setCertificate($params['cert']);
        }
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
}
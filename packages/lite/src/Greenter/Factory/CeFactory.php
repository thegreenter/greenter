<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:00
 */

namespace Greenter\Factory;

use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;
use Greenter\Security\SignedXml;
use Greenter\Ws\Services\CeSunat;
use Greenter\Ws\Services\FeSunat;
use Greenter\Ws\Services\WsSunatInterface;
use Greenter\Xml\Builder\CeBuilder;
use Greenter\Xml\Builder\CeBuilderInterface;
use Greenter\Zip\ZipFactory;

class CeFactory implements CeFactoryInterface
{
    /**
     * @var CeBuilderInterface
     */
    private $builder;

    /**
     * @var SignedXml
     */
    private $signer;

    /**
     * @var ZipFactory
     */
    private $zipper;

    /**
     * @var WsSunatInterface
     */
    private $sender;

    /**
     * Ultimo xml generado.
     *
     * @var string
     */
    private $lastXml;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var bool
     */
    private $isProd;

    /**
     * CeFactory constructor.
     */
    public function __construct()
    {
        $this->builder = new CeBuilder();
        $this->signer = new SignedXml();
        $this->sender = new FeSunat();
        $this->zipper = new ZipFactory();
    }

    /**
     * Envia una Guia de Remision.
     *
     * @param Despatch $despatch
     * @return BillResult
     */
    public function sendDispatch(Despatch $despatch)
    {
        $xml = $this->builder->buildDespatch($despatch);
        $filename = $despatch->getFilename($this->company->getRuc());

        $this->setService(true);
        return $this->getBillResult($xml, $filename);
    }

    /**
     * Envia una Retencion.
     *
     * @param Retention $retention
     * @return BillResult
     */
    public function sendRetention(Retention $retention)
    {
        $xml = $this->builder->buildRetention($retention);
        $filename = $retention->getFilename($this->company->getRuc());

        $this->setService();
        return $this->getBillResult($xml, $filename);
    }

    /**
     * Envia una Percepcion.
     *
     * @param Perception $perception
     * @return BillResult
     */
    public function sendPerception(Perception $perception)
    {
        $xml = $this->builder->buildPerception($perception);
        $filename = $perception->getFilename($this->company->getRuc());

        $this->setService();
        return $this->getBillResult($xml, $filename);
    }

    /**
     * Envia una Resumen de Reversiones.
     *
     * @param Reversion $reversion
     * @return SummaryResult
     */
    public function sendReversion(Reversion $reversion)
    {
        $xml = $this->builder->buildReversion($reversion);
        $filename = $reversion->getFileName($this->company->getRuc());

        $this->setService();
        return $this->getSummaryResult($xml, $filename);
    }

    /**
     * Get Status by Ticket.
     *
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket)
    {
        $this->setService();
        return $this->sender->getStatus($ticket);
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
     * Set Company
     *
     * @param $company
     * @return $this
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        $this->builder->setCompany($company);

        return $this;
    }

    /**
     * @param array $params
     */
    public function setParameters($params)
    {
        $this->setWsParams($params['ws']);

        if (isset($params['xml'])) {
            $this->builder->setParameters($params['xml']);
        }

        if (isset($params['cert'])) {
            $this->signer->setCertificate($params['cert']);
        }
    }

    /**
     * @param array $ws
     */
    private function setWsParams($ws)
    {
        $this->sender->setCredentials($ws['user'], $ws['pass']);
        if (isset($ws['service'])) {
            $this->isProd = $ws['service'] == FeSunat::PRODUCCION;
        }
        if (isset($ws['wsdl'])) {
            $this->sender->setUrlWsdl($ws['wsdl']);
        }
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return BillResult
     */
    private function getBillResult($xml, $filename)
    {
        $this->lastXml = $this->getXmmlSigned($xml);

        $zip = $this->zipper->compress("$filename.xml", $this->lastXml);
        return $this->sender->send("$filename.zip", $zip);
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return SummaryResult
     */
    private function getSummaryResult($xml, $filename)
    {
        $this->lastXml = $this->getXmmlSigned($xml);

        $zip = $this->zipper->compress("$filename.xml", $this->lastXml);
        return $this->sender->sendSummary("$filename.zip", $zip);
    }

    private function setService($isGuia = false)
    {
        if ($isGuia === true) {
            $this->sender->setService($this->isProd ? CeSunat::GUIA_PRODUCCION : CeSunat::GUIA_BETA);
            return;
        }

        $this->sender->setService($this->isProd ? CeSunat::RETENCION_PRODUCCION : CeSunat::RETENCION_BETA);
    }

    /**
     * @param string $xml
     * @return string
     */
    private function getXmmlSigned($xml)
    {
        return $this->signer->sign($xml);
    }
}
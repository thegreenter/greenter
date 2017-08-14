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
use Greenter\Ws\Services\CeSunat;
use Greenter\Xml\Builder\CeBuilder;
use Greenter\Xml\Builder\CeBuilderInterface;

class CeFactory extends BaseFactory implements CeFactoryInterface
{
    /**
     * @var CeBuilderInterface
     */
    private $builder;

    /**
     * @var bool
     */
    private $isProd;

    /**
     * CeFactory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->builder = new CeBuilder();
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

    private function setService($isGuia = false)
    {
        if ($isGuia === true) {
            $this->sender->setService($this->isProd ? CeSunat::GUIA_PRODUCCION : CeSunat::GUIA_BETA);
            return;
        }

        $this->sender->setService($this->isProd ? CeSunat::RETENCION_PRODUCCION : CeSunat::RETENCION_BETA);
    }
}
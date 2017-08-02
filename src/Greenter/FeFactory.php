<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter;

use Greenter\Model\Company\Company;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Ws\Services\WsSunatInterface;
use Greenter\Xml\Builder\FeBuilderInteface;
use Greenter\Zip\ZipFactory;
use Greenter\Security\SignedXml;
use Greenter\Ws\Services\FeSunat;
use Greenter\Xml\Builder\FeBuilder;
use Greenter\Model\Sale\Invoice;

class FeFactory implements FeFactoryInterface
{
    /**
     * @var FeBuilderInteface
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
     * FeFactory constructor.
     */
    public function __construct()
    {
        $this->builder = new FeBuilder();
        $this->signer = new SignedXml();
        $this->sender = new FeSunat();
        $this->zipper = new ZipFactory();
    }

    /**
     * @param Invoice $invoice
     * @return BillResult
     */
    public function sendInvoice(Invoice $invoice)
    {
        $xml = $this->builder->buildInvoice($invoice);
        $filename = $invoice->getFilename($this->company->getRuc());

        return $this->getBillResult($xml, $filename);
    }

    /**
     * Envia una Nota de Credito o Debito.
     *
     * @param Note $note
     * @return BillResult
     */
    public function sendNote(Note $note)
    {
        $xml = $this->builder->buildNote($note);
        $filename = $note->getFilename($this->company->getRuc());

        return $this->getBillResult($xml, $filename);
    }

    /**
     * Envia un resumen diario de Boletas.
     *
     * @param Summary $summary
     * @return SummaryResult
     */
    public function sendResumen(Summary $summary)
    {
        $xml = $this->builder->buildSummary($summary);
        $filename = $summary->getFileName($this->company->getRuc());

        return $this->getSummaryResult($xml, $filename);
    }

    /**
     * Envia una comunicacion de Baja.
     *
     * @param Voided $voided
     * @return SummaryResult
     */
    public function sendBaja(Voided $voided)
    {
        $xml = $this->builder->buildVoided($voided);
        $filename = $voided->getFileName($this->company->getRuc());

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
        return $this->sender->getStatus($ticket);
    }

    /**
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
     * Get Last XML Signed.
     *
     * @return string
     */
    public function getLastXml()
    {
        return $this->lastXml;
    }

    /**
     * @param array $ws
     */
    private function setWsParams($ws)
    {
        $this->sender->setCredentials($ws['user'], $ws['pass']);
        if (isset($ws['service'])) {
            $this->sender->setService($ws['service']);
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

    /**
     * @param string $xml
     * @return string
     */
    private function getXmmlSigned($xml)
    {
        return $this->signer->sign($xml);
    }
}
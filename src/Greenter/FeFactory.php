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
use Greenter\Model\Sale\BaseSale;
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
        $filename = $this->getFilename($invoice);

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
        $filename = $this->getFilename($note);

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
        $filename = $this->getFilenameSummary($summary);

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
        $filename = $this->getFilenameSummary($voided);

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
        $auth = $params['auth'];
        if ($auth) {
            $this->sender->setCredentials($auth['user'], $auth['pass']);
        }

        $xml = $params['xml'];
        if ($xml) {
            $this->builder->setParameters($xml);
        }

        $cert = $params['cert'];

        if ($cert) {
            $this->signer->setPrivateKey($cert['private']);
            $this->signer->setPublicKey($cert['public']);
        }
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return BillResult
     */
    private function getBillResult($xml, $filename)
    {
        $xmlS = $this->signer->sign($xml);

        $zip = $this->zipper->compress("$filename.xml", $xmlS);
        return $this->sender->send("$filename.zip", $zip);
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return SummaryResult
     */
    private function getSummaryResult($xml, $filename)
    {
        $xmlS = $this->signer->sign($xml);

        $zip = $this->zipper->compress("$filename.xml", $xmlS);
        return $this->sender->sendSummary("$filename.zip", $zip);
    }

    /**
     * @param BaseSale $sale
     * @return string
     */
    private function getFilename(BaseSale $sale)
    {
        $parts = [
            $this->company->getRuc(),
            $sale->getTipoDoc(),
            $sale->getSerie(),
            $sale->getCorrelativo(),
        ];

        return join('-', $parts);
    }


    /**
     * @param Summary|Voided $object
     * @return string
     */
    private function getFilenameSummary($object)
    {
        $parts = [$this->company->getRuc()];

        if ($object instanceof Summary) {
            $parts[] = 'RC';
            $parts[] = $object->getFecResumen()->format('Ymd');
        } elseif ($object instanceof Voided) {
            $parts[] = 'RA';
            $parts[] = $object->getFecComunicacion()->format('Ymd');
        }
        $parts[] = $object->getCorrelativo();

        return join('-', $parts);
    }
}
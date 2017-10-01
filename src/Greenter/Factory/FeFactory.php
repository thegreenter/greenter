<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter\Factory;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Builder\FeBuilderInteface;
use Greenter\Xml\Builder\FeBuilder;
use Greenter\Model\Sale\Invoice;

/**
 * Class FeFactory
 * @package Greenter\Factory
 */
class FeFactory extends BaseFactory implements FeFactoryInterface
{
    /**
     * @var FeBuilderInteface
     */
    private $builder;

    /**
     * FeFactory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->builder = new FeBuilder();
    }

    /**
     * @param Invoice $invoice
     * @return BillResult
     */
    public function sendInvoice(Invoice $invoice)
    {
        $xml = $this->builder->buildInvoice($invoice);
        $filename = $invoice->getName();

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
        $filename = $note->getName();

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
        $filename = $summary->getName();

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
        $filename = $voided->getName();

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
}
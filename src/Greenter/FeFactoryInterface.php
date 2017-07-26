<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 25/07/2017
 * Time: 19:24
 */

namespace Greenter;


use Greenter\Model\Company\Company;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;

/**
 * Interface FeFactoryInterface
 * @package Greenter
 */
interface FeFactoryInterface
{
    /**
     * Envia una Factura o Boleta.
     *
     * @param Invoice $invoice
     * @return BillResult
     */
    public function sendInvoice(Invoice $invoice);


    /**
     * Envia una Nota de Credito o Debito.
     *
     * @param Note $note
     * @return BillResult
     */
    public function sendNote(Note $note);

    /**
     * Envia un resumen diario de Boletas.
     *
     * @param Summary $summary
     * @return SummaryResult
     */
    public function sendResumen(Summary $summary);

    /**
     * Envia una comunicacion de Baja.
     *
     * @param Voided $voided
     * @return SummaryResult
     */
    public function sendBaja(Voided $voided);

    /**
     * Get Status by Ticket.
     *
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket);
    /**
     * Set Company
     *
     * @param $company
     * @return $this
     */
    public function setCompany(Company $company);
}
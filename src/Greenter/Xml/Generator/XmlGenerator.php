<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 20:53
 */

namespace Greenter\Xml\Generator;

use Greenter\Xml\Model\Company\Company;
use Greenter\Xml\Model\Sale\Invoice;
use Greenter\Xml\Model\Sale\Note;
use Greenter\Xml\Model\Summary\Summary;
use Greenter\Xml\Model\Voided\Voided;

/**
 * Interface XmlGenerator
 * @package Greenter\Xml\Generator
 */
interface XmlGenerator
{
    /**
     * Genera un invoice (Factura o Boleta).
     *
     * @param Invoice $invoice
     * @return string
     */
    public function buildInvoice(Invoice $invoice);

    /**
     * Genera una Nota Electrónica(Credito o Debito).
     *
     * @param Note $note
     * @return string
     */
    public function buildNote(Note $note);

    /**
     * Genera una Resumen Diario de Boletas.
     *
     * @param Summary $summary
     * @return string
     */
    public function buildSummary(Summary $summary);

    /**
     * Genera una comunicacion de Baja.
     *
     * @param Voided $voided
     * @return string
     */
    public function buildVoided(Voided $voided);

    /**
     * @param Company $company
     * @return FeGenerator
     */
    public function setCompany(Company $company);
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 20:53
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;

/**
 * Interface XmlBuilder
 * @package Greenter\Xml\Builder
 */
interface FeBuilderInteface
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
     * Set argumentos.
     *
     * @param array $params
     */
    public function setParameters($params);
}
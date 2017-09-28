<?php

/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:15
 */
namespace Greenter\Xml\Builder;

use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Exception\ValidationException;

/**
 * Class FeBuilder
 * @package Greenter\Xml\Builder
 */
final class FeBuilder extends BaseBuilder implements FeBuilderInteface
{
    /**
     * Genera un invoice (Factura o Boleta).
     *
     * @param Invoice $invoice
     * @throws ValidationException
     * @return string
     */
    public function buildInvoice(Invoice $invoice)
    {
        $this->validate($invoice);

        return $this->render('invoice.html.twig', $invoice);
    }

    /**
     * Genera una Nota Electrónica(Credito o Debito).
     *
     * @param Note $note
     * @throws ValidationException
     * @return string
     */
    public function buildNote(Note $note)
    {
        $this->validate($note);

        $template = $note->getTipoDoc() === '07'
            ? 'notacr.html.twig' : 'notadb.html.twig';

        return $this->render($template, $note);
    }

    /**
     * Genera una Resumen Diario de Boletas.
     *
     * @param Summary $summary
     * @throws ValidationException
     * @return string
     */
    public function buildSummary(Summary $summary)
    {
        $this->validate($summary);

        return $this->render('summary.html.twig', $summary);
    }

    /**
     * Genera una comunicacion de Baja.
     *
     * @param Voided $voided
     * @throws ValidationException
     * @return string
     */
    public function buildVoided(Voided $voided)
    {
        $this->validate($voided);

        return $this->render('voided.html.twig', $voided);
    }

    /**
     * Set argumentos.
     *
     * @param array $params
     * @throws \Exception
     */
    public function setParameters($params)
    {
        $this->addParameters($params);
    }
}
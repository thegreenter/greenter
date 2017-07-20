<?php

/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:15
 */
namespace Greenter\Xml\Generator;

use Greenter\Xml\Model\Company\Company;
use Greenter\Xml\Model\Sale\Invoice;
use Greenter\Xml\Model\Sale\Note;
use Greenter\Xml\Model\Summary\Summary;
use Greenter\Xml\Model\Voided\Voided;
use Symfony\Component\Validator\Validation;
use Twig_Environment;
use Twig_Loader_Filesystem;


/**
 * Class FeGenerator
 * @package Greenter\Xml\Generator
 */
final class FeGenerator implements XmlGenerator
{
    /**
     * Directorio de Cache para las template de Documentos.
     * @var string
     */
    private $dirCache;

    /**
     * Datos de la Compañia.
     *
     * @var Company
     */
    private $company;

    /**
     * Genera un invoice (Factura o Boleta).
     *
     * @param Invoice $invoice
     * @return string
     */
    public function buildInvoice(Invoice $invoice)
    {
        $errors = $this->validate($invoice);

        if ($errors->count() > 0) {
            return '';
        }

        return $this->render('invoice.html.twig', $invoice);
    }

    /**
     * Genera una Nota Electrónica(Credito o Debito).
     *
     * @param Note $note
     * @return string
     */
    public function buildNote(Note $note)
    {
        $errors = $this->validate($note);

        if ($errors->count() > 0) {
            return '';
        }

        $template = $note->getTipoDoc() === '07'
            ? 'notacr.html.twig' : 'notadb.html.twig';

        return $this->render($template, $note);
    }

    /**
     * Genera una Resumen Diario de Boletas.
     *
     * @param Summary $summary
     * @return string
     */
    public function buildSummary(Summary $summary)
    {
        $errors = $this->validate($summary);

        if ($errors->count() > 0) {
            return '';
        }

        return $this->render('summary.html.twig', $summary);
    }

    /**
     * Genera una comunicacion de Baja.
     *
     * @param Voided $voided
     * @return string
     */
    public function buildVoided(Voided $voided)
    {
        $errors = $this->validate($voided);

        if ($errors->count() > 0) {
            return '';
        }

        $twig = $this->getRender();
        return $twig->render('voided.html.twig', [
            'doc' => $voided,
            'emp' => $this->company,
        ]);
    }

    /**
     * @param string $dirCache
     * @return FeGenerator
     */
    public function setDirCache($dirCache)
    {
        $this->dirCache = $dirCache;
        return $this;
    }

    /**
     * @param Company $company
     * @return FeGenerator
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get Content XML from template.
     *
     * @param string $template
     * @param object $doc
     * @return string
     */
    private function render($template, $doc)
    {
        $twig = $this->getRender();
        return $twig->render($template, [
            'doc' => $doc,
            'emp' => $this->company,
        ]);
    }

    private function getRender()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => $this->dirCache,
        ));

        return $twig;
    }

    private function validate($entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        return $validator->validate($entity);
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:15
 */
namespace Greenter\Xml\Builder;

use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Exception\ValidationException;
use Symfony\Component\Validator\Validation;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class FeBuilder
 * @package Greenter\Xml\Builder
 */
final class FeBuilder implements FeBuilderInteface
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
     * FeBuilder constructor.
     */
    public function __construct()
    {
        $this->dirCache = sys_get_temp_dir();
    }

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

        $twig = $this->getRender();
        return $twig->render('voided.html.twig', [
            'doc' => $voided,
            'emp' => $this->company,
        ]);
    }

    /**
     * @param Company $company
     * @return FeBuilder
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Set argumentos.
     *
     * @param array $params
     * @throws \Exception
     */
    public function setParameters($params)
    {
        if (!$params['cache']) {
            return;
        }

        if (!is_dir($params['cache'])) {
            throw new \Exception('No is a directory valid');
        }

        $this->dirCache = $params['cache'];
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

    /**
     * Validate Entity.
     *
     * @param object $entity
     * @throws ValidationException
     */
    private function validate($entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errs = $validator->validate($entity);
        if ($errs->count() > 0) {
            throw new ValidationException($errs);
        }
    }
}
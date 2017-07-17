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
final class FeGenerator
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

    public function buildFact(Invoice $invoice)
    {
        $validator = Validation::createValidatorBuilder()
        ->enableAnnotationMapping()
        ->getValidator();

        $errors = $validator->validate($invoice);

        if ($errors->count() > 0) {
            return;
        }

        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => $this->dirCache,
        ));

        echo $twig->render('invoice.html.twig', [
            'doc' => $invoice,
            'emp' => $this->company,
        ]);
    }

    public function buildNote(Note $note)
    {

    }

    public function buildSummary(Summary $summary)
    {

    }

    public function buildVoided(Voided $voided)
    {

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
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

}
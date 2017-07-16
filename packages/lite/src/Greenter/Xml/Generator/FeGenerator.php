<?php

/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:15
 */
namespace Greenter\Xml\Generator;

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
class FeGenerator
{
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
            'cache' => '/cache',
        ));

        echo $twig->render('invoice.twig', ['doc' => $invoice]);
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
}
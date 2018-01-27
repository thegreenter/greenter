<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:36 PM.
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class SymfonyValidator.
 */
class SymfonyValidator implements DocumentValidatorInterface
{
    private $validator;

    /**
     * SymfonyValidator constructor.
     * @param TranslatorInterface|null $translator
     */
    public function __construct(TranslatorInterface $translator = null)
    {
        if ($translator == null) {
            $translator = $this->getTranslator();
        }

        $metaDataFactory = new CustomMetadataFactory();

        $this->validator = Validation::createValidatorBuilder()
            ->setMetadataFactory($metaDataFactory)
            ->setTranslator($translator)
            ->getValidator();
    }

    /**
     * @param DocumentInterface $document
     *
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validate(DocumentInterface $document)
    {
        return $this->validator->validate($document);
    }

    private function getTranslator()
    {
        $translator = new Translator('es_PE', new MessageSelector());
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', CodeTranslate::$ErrorCodes, 'es_PE');

        return $translator;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:36 PM
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class SymfonyValidator
 * @package Greenter\Validator
 */
class SymfonyValidator implements DocumentValidatorInterface
{
    /**
     * @param DocumentInterface $document
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     * @throws \Exception
     */
    public function validate(DocumentInterface $document)
    {
        $metaDataFactory = new CustomMetadataFactory();

        $validator = Validation::createValidatorBuilder()
            ->setMetadataFactory($metaDataFactory)
            ->getValidator();

        return $validator->validate($document);
    }
}
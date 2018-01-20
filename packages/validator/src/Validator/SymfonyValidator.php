<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:36 PM.
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class SymfonyValidator.
 */
class SymfonyValidator implements DocumentValidatorInterface
{
    private $validator;

    /**
     * SymfonyValidator constructor.
     */
    public function __construct()
    {
        $metaDataFactory = new CustomMetadataFactory();

        $this->validator = Validation::createValidatorBuilder()
            ->setMetadataFactory($metaDataFactory)
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
}

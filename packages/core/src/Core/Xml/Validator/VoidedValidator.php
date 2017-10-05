<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:20 PM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait VoidedValidator
 * @package Greenter\Xml\Validator
 */
trait VoidedValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 3]),
        ]);
        $metadata->addPropertyConstraint('fecGeneracion', new Assert\Date());
        $metadata->addPropertyConstraints('fecComunicacion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('details', new Assert\Valid());
    }
}
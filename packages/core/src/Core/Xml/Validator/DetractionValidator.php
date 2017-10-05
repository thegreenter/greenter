<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 10:09 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait DetractionValidator
 * @package Greenter\Xml\Validator
 */
trait DetractionValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('percent', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('mount', new Assert\NotBlank());
    }
}
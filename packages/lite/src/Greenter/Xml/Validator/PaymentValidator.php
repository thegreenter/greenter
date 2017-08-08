<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:55 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait PaymentValidator
 * @package Greenter\Xml\Validator
 */
trait PaymentValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 3, 'max' => 3]),
        ]);
        $metadata->addPropertyConstraint('importe', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fecha', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
    }
}
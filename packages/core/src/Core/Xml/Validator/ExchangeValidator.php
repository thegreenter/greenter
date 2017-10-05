<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:11 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait ExchangeValidator
 * @package Greenter\Xml\Validator
 */
trait ExchangeValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('monedaRef', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 3, 'max' => 3]),
        ]);
        $metadata->addPropertyConstraints('monedaObj', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 3, 'max' => 3]),
        ]);
        $metadata->addPropertyConstraint('factor', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fecha', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
    }
}
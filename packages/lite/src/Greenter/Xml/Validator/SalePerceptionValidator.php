<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:37
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait SalePerceptionValidator
 * @package Greenter\Xml\Validator
 */
trait SalePerceptionValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codReg', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraint('mtoBase', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mto', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoTotal', new Assert\NotBlank());
    }
}
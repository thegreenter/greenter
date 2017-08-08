<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:49
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait DespatchDetailValidator
 * @package Greenter\Xml\Validator
 */
trait DespatchDetailValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codigo', [
            new Assert\Length(['max' => 16]),
        ]);
        $metadata->addPropertyConstraints('descripcion', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 250]),
        ]);
        $metadata->addPropertyConstraints('unidad', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraint('cantidad', new Assert\NotBlank());
    }
}
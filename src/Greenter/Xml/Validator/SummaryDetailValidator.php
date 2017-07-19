<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:22
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait SummaryDetailValidator
 * @package Greenter\Xml\Validator
 */
trait SummaryDetailValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 4,
                'max' => 4,
            ]),
        ]);
        $metadata->addPropertyConstraints('docInicio', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('docFin', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraint('total', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperGravadas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperInafectas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperExoneradas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoIGV', new Assert\NotBlank());

    }
}
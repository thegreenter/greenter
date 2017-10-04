<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:35 PM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait SummaryDetailV2Validator
 * @package Greenter\Xml\Validator
 */
trait SummaryDetailV2Validator
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
        $metadata->addPropertyConstraints('serieNro', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 13]),
        ]);
        $metadata->addPropertyConstraints('clienteTipo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 1]),
        ]);
        $metadata->addPropertyConstraints('clienteNro', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 20]),
        ]);
        $metadata->addPropertyConstraints('estado', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 1]),
        ]);
        $metadata->addPropertyConstraint('docReferencia', new Assert\Valid());
        $metadata->addPropertyConstraint('total', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperGravadas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperInafectas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperExoneradas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoIGV', new Assert\NotBlank());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:00 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait ShipmentValidator
 * @package Greenter\Xml\Validator
 */
trait ShipmentValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codTraslado', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraint('desTraslado', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('indTransbordo', new Assert\Type(['type' => 'bool']));
        $metadata->addPropertyConstraint('pesoTotal', new Assert\NotBlank());
        $metadata->addPropertyConstraints('undPesoTotal', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('modTraslado', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraints('fecTraslado', [
            new Assert\NotBlank(),
            new Assert\Date()
        ]);
        $metadata->addPropertyConstraint('numContenedor', new Assert\Length(['max' => 17]));
        $metadata->addPropertyConstraint('codPuerto', new Assert\Length(['max' => 3]));
        $metadata->addPropertyConstraint('transportista', new Assert\Valid());
        $metadata->addPropertyConstraint('llegada', new Assert\Valid());
        $metadata->addPropertyConstraint('partida', new Assert\Valid());
    }
}
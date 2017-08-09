<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:22 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait RetentionValidator
 * @package Greenter\Xml\Validator
 */
trait RetentionValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('proveedor', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('regimen', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraint('tasa', new Assert\NotBlank());
        $metadata->addPropertyConstraint('impRetenido', new Assert\NotBlank());
        $metadata->addPropertyConstraint('impPagado', new Assert\NotBlank());
        $metadata->addPropertyConstraint('observacion', new Assert\Length(['max' => 250]));
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
    }
}
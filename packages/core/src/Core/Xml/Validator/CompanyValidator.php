<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 05/10/2017
 * Time: 06:44 PM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait CompanyValidator
 * @package Greenter\Xml\Validator
 */
trait CompanyValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('ruc', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 11, 'max' => 11]),
        ]);
        $metadata->addPropertyConstraints('rznSocial', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
        $metadata->addPropertyConstraint('nombreComercial', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('address', new Assert\Valid());
    }
}
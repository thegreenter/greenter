<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:04
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait ClientValidator
 * @package Greenter\Xml\Validator
 */
trait ClientValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1, 'max' => 1]),
        ]);
        $metadata->addPropertyConstraints('numDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 15]),
        ]);
        $metadata->addPropertyConstraints('rznSocial', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
    }
}
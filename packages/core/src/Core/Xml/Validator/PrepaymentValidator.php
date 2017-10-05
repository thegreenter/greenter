<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/09/2017
 * Time: 08:31 PM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait PrepaymentValidator
 * @package Greenter\Xml\Validator
 */
trait PrepaymentValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDocRel', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('nroDocRel', [
            new Assert\NotBlank(),
            new Assert\Length([ 'max' => 30]),
        ]);
        $metadata->addPropertyConstraints('total',[
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
    }
}
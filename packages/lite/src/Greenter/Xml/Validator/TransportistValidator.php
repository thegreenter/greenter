<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:52
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait TransportistValidator
 * @package Greenter\Xml\Validator
 */
trait TransportistValidator
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
        $metadata->addPropertyConstraints('placa', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('choferTipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1, 'max' => 1]),
        ]);
        $metadata->addPropertyConstraints('choferDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 11]),
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:20
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait SummaryValidator
 * @package Greenter\Xml\Validator
 */
trait SummaryValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 3]),
        ]);
        $metadata->addPropertyConstraint('fecGeneracion', new Assert\Date());
        $metadata->addPropertyConstraints('fecResumen', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('details', new Assert\Valid());
    }
}
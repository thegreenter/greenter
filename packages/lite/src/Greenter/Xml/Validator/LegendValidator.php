<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 23:40
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait LegendValidator
 * @package Greenter\Xml\Validator
 */
trait LegendValidator
{
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('code', new Assert\Length([
            'min'=> 4,
            'max' => 4,
        ]));
        $metadata->addPropertyConstraint('value', new Assert\Length(['max' => 100]));
    }
}
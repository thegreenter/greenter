<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:27 AM
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait InvoiceValidator
 * @package Greenter\Xml\Validator
 */
trait InvoiceValidator
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
            new Assert\Length([ 'max' => 4]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraint('fechaEmision', new Assert\Date());
        $metadata->addPropertyConstraints('tipoMoneda', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 3]),
        ]);
        $metadata->addPropertyConstraint('mtoOperGravadas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperInafectas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperExoneradas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoImpVenta', new Assert\NotBlank());
        $metadata->addPropertyConstraint('client', new Assert\NotBlank());
        $metadata->addPropertyConstraint('client', new Assert\Valid());
        $metadata->addPropertyConstraint('details', new Assert\Valid());
        $metadata->addPropertyConstraint('legends', new Assert\Valid());
        $metadata->addPropertyConstraint('relDocs', new Assert\Valid());
        $metadata->addPropertyConstraint('perception', new Assert\Valid());
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 22:27
 */

namespace Greenter\Xml\Validator;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait NoteValidator
 * @package Greenter\Xml\Validator
 */
trait NoteValidator
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
        $metadata->addPropertyConstraints('tipoDocUsuario', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 1]),
        ]);
        $metadata->addPropertyConstraints('numDocUsuario', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 15]),
        ]);
        $metadata->addPropertyConstraints('rznSocialUsuario', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
        $metadata->addPropertyConstraints('tipoMoneda', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 3]),
        ]);
        $metadata->addPropertyConstraint('mtoOperGravadas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperInafectas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoOperExoneradas', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoImpVenta', new Assert\NotBlank());
        $metadata->addPropertyConstraint('details', new Assert\Valid());
        $metadata->addPropertyConstraint('legends', new Assert\Valid());
        $metadata->addPropertyConstraint('relDocs', new Assert\Valid());
        $metadata->addPropertyConstraint('perception', new Assert\Valid());
        $metadata->addPropertyConstraints('codMotivo', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('desMotivo', [
            new Assert\NotBlank(),
            new Assert\Length([ 'max' => 250]),
        ]);
        $metadata->addPropertyConstraints('tipDocAfectado', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('numDocfectado', [
            new Assert\NotBlank(),
            new Assert\Length([ 'max' => 13]),
        ]);
    }
}
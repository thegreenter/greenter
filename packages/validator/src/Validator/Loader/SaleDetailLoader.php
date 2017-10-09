<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:38 AM
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SaleDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codUnidadMedida', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 3]),
        ]);
        $metadata->addPropertyConstraints('desItem', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 250]),
        ]);
        $metadata->addPropertyConstraint('mtoValorUnitario', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoIgvItem', new Assert\NotBlank());
        $metadata->addPropertyConstraint('tipAfeIgv', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoPrecioUnitario', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoValorVenta', new Assert\NotBlank());
    }
}
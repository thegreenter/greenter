<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:38 AM.
 */

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Greenter\Validator\Constraint as MyAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SaleDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('unidad', [
            new Assert\NotBlank(),
            new MyAssert\CodeUnit(),
        ]);
        $metadata->addPropertyConstraints('descripcion', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 500]),
        ]);
        $metadata->addPropertyConstraint('cantidad', new Assert\NotBlank());
        $metadata->addPropertyConstraint('codProducto', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('codProdSunat', new Assert\Length(['max' => 8]));
        $metadata->addPropertyConstraint('codProdGS1', new Assert\Length(['max' => 14]));
        $metadata->addPropertyConstraint('mtoPrecioUnitario', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoValorGratuito', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraints('mtoValorUnitario', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoValorVenta', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('totalImpuestos', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('tipAfeIgv', new Assert\NotBlank());
        $metadata->addPropertyConstraints('igv', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoBaseIgv', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('porcentajeIgv', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('isc', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoBaseIsc', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('porcentajeIsc', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoBaseOth', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('otroTributo', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('porcentajeOth', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('cargos', new Assert\Valid());
        $metadata->addPropertyConstraint('descuentos', new Assert\Valid());
        $metadata->addPropertyConstraint('atributos', new Assert\Valid());
    }
}

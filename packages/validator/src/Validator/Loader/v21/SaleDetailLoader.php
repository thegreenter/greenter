<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:38 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SaleDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('unidad', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('descripcion', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 500]),
        ]);
        $metadata->addPropertyConstraint('cantidad', new Assert\NotBlank());
        $metadata->addPropertyConstraint('codProducto', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('codProdSunat', new Assert\Length(['max' => 8]));
        $metadata->addPropertyConstraint('codProdGS1', new Assert\Length(['max' => 14]));
        $metadata->addPropertyConstraints('mtoValorUnitario', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mtoValorVenta', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('totalImpuestos', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('tipAfeIgv', new Assert\NotBlank());
        $metadata->addPropertyConstraints('igv', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mtoBaseIgv', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('porcentajeIgv', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('cargos', new Assert\Valid());
        $metadata->addPropertyConstraint('descuentos', new Assert\Valid());
        $metadata->addPropertyConstraint('atributos', new Assert\Valid());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:38 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SaleDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('unidad', new Assert\NotBlank());
        $metadata->addPropertyConstraints('descripcion', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 250]),
        ]);
        $metadata->addPropertyConstraint('cantidad', new Assert\NotNull());
        $metadata->addPropertyConstraint('codProducto', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('codProdSunat', new Assert\Length(['max' => 20]));
        $metadata->addPropertyConstraint('mtoValorUnitario', new Assert\NotNull());
        $metadata->addPropertyConstraint('igv', new Assert\NotNull());
        $metadata->addPropertyConstraint('tipAfeIgv', new Assert\NotNull());
        $metadata->addPropertyConstraint('mtoPrecioUnitario', new Assert\NotNull());
        $metadata->addPropertyConstraint('mtoValorVenta', new Assert\NotNull());
    }
}

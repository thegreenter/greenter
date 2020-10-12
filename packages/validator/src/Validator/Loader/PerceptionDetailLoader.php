<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:37 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class PerceptionDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 2]),
        ]);
        $metadata->addPropertyConstraints('numDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 13]),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('impTotal', new Assert\NotNull());
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('cobros', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('impCobrar', new Assert\NotNull());
        $metadata->addPropertyConstraints('fechaPercepcion', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('impPercibido', new Assert\NotNull());
        $metadata->addPropertyConstraint('tipoCambio', new Assert\Valid());
    }
}

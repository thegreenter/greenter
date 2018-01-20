<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:37 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\LoaderMetadataInterface;
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
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraint('impTotal', new Assert\NotBlank());
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 3, 'max' => 3]),
        ]);
        $metadata->addPropertyConstraints('cobros', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('impCobrar', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fechaPercepcion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraint('impPercibido', new Assert\NotBlank());
        $metadata->addPropertyConstraint('tipoCambio', new Assert\Valid());
    }
}

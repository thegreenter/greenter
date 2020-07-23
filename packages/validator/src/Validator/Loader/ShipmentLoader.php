<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:00 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ShipmentLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codTraslado', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraint('desTraslado', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('indTransbordo', new Assert\Type(['type' => 'bool']));
        $metadata->addPropertyConstraint('pesoTotal', new Assert\NotBlank());
        $metadata->addPropertyConstraints('undPesoTotal', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('modTraslado', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraints('fecTraslado', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('numContenedor', new Assert\Length(['max' => 17]));
        $metadata->addPropertyConstraint('codPuerto', new Assert\Length(['max' => 3]));
        $metadata->addPropertyConstraint('transportista', new Assert\Valid());
        $metadata->addPropertyConstraint('llegada', new Assert\Valid());
        $metadata->addPropertyConstraint('partida', new Assert\Valid());
    }
}

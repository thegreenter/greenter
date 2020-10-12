<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:49.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DespatchDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codigo', [
            new Assert\Length(['max' => 16]),
        ]);
        $metadata->addPropertyConstraints('descripcion', [
            new Assert\Required(),
            new Assert\Length(['max' => 250]),
        ]);
        $metadata->addPropertyConstraints('unidad', [
            new Assert\Required(),
        ]);
        $metadata->addPropertyConstraints('cantidad', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('codProdSunat', new Assert\Length(['max' => 20]));
    }
}

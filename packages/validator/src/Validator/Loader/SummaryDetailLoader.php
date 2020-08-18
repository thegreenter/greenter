<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:22.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('serieNro', new Assert\NotBlank());
        $metadata->addPropertyConstraints('clienteTipo', [
            new Assert\Length(['max' => 1]),
        ]);
        $metadata->addPropertyConstraints('clienteNro', [
            new Assert\Length(['max' => 20]),
        ]);
        $metadata->addPropertyConstraints('estado', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('docReferencia', new Assert\Valid());
        $metadata->addPropertyConstraint('percepcion', new Assert\Valid());
        $metadata->addPropertyConstraints('total', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mtoIGV', [
            new Assert\NotNull(),
        ]);
    }
}

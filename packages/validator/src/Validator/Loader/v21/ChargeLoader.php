<?php

declare(strict_types=1);

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ChargeLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('factor', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('monto', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('montoBase', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('codTipo', new Assert\NotBlank());
    }
}

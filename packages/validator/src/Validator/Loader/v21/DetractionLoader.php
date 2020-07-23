<?php

declare(strict_types=1);

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DetractionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('percent', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mount', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraint('codMedioPago', new Assert\NotBlank());
        $metadata->addPropertyConstraint('ctaBanco', new Assert\NotBlank());
        $metadata->addPropertyConstraint('codBienDetraccion', new Assert\NotBlank());
    }
}

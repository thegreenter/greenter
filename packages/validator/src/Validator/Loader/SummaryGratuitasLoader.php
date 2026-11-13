<?php

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryGratuitasLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        foreach (['mtoGravadas', 'mtoExoneradas', 'mtoInafectas', 'mtoExportacion', 'mtoIgv'] as $field) {
            $metadata->addPropertyConstraint($field, new Assert\PositiveOrZero());
        }
    }
}

<?php

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class FormaPagoContadoLoader implements LoaderMetadataInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('tipo', new Assert\NotBlank());
    }
}

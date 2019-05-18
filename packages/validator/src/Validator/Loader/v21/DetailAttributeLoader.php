<?php


namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DetailAttributeLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('code', new Assert\NotBlank());
        $metadata->addPropertyConstraint('fecInicio', new Assert\DateTime());
        $metadata->addPropertyConstraint('fecFin', new Assert\DateTime());
        $metadata->addPropertyConstraint('duracion', new Assert\Type(['type' => 'int']));
    }
}
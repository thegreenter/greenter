<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 10:09 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DetractionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('percent', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('mount', new Assert\NotBlank());
    }
}

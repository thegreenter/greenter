<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:37.
 */

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SalePerceptionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('codReg', new Assert\NotBlank());
        $metadata->addPropertyConstraints('mtoBase', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mto', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoTotal', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('porcentaje', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
    }
}

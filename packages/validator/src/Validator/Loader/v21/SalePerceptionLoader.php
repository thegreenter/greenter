<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:37.
 */

declare(strict_types=1);

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
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mto', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mtoTotal', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('porcentaje', [
            new Assert\NotNull(),
        ]);
    }
}

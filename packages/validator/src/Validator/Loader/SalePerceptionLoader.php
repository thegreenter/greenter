<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 15:37.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SalePerceptionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codReg', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('mtoBase', [
            new Assert\NotNull(),
            new Assert\Type(['type' => 'float']),
        ]);
        $metadata->addPropertyConstraints('mto', [
            new Assert\NotNull(),
            new Assert\Type(['type' => 'float']),
        ]);
        $metadata->addPropertyConstraints('mtoTotal', [
            new Assert\NotNull(),
            new Assert\Type(['type' => 'float']),
        ]);
    }
}

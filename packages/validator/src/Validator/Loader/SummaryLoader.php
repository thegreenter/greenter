<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:20.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 5]),
        ]);
        $metadata->addPropertyConstraints('fecGeneracion', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('fecResumen', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
        ]);
    }
}

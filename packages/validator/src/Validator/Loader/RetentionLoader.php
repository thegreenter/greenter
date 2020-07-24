<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:22 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class RetentionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('proveedor', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('regimen', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 2, 'max' => 2]),
        ]);
        $metadata->addPropertyConstraint('tasa', new Assert\NotNull());
        $metadata->addPropertyConstraint('impRetenido', new Assert\NotNull());
        $metadata->addPropertyConstraint('impPagado', new Assert\NotNull());
        $metadata->addPropertyConstraint('observacion', new Assert\Length(['max' => 250]));
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
    }
}

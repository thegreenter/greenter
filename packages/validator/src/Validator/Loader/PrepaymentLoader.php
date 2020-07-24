<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/09/2017
 * Time: 08:31 PM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class PrepaymentLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDocRel', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('nroDocRel', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 30]),
        ]);
        $metadata->addPropertyConstraints('total', [
            new Assert\NotNull(),
        ]);
    }
}

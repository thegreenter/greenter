<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:21 PM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class VoidedDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 2,
                'max' => 2,
            ]),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length([
                'min' => 4,
                'max' => 4,
            ]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('desMotivoBaja', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
    }
}

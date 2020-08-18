<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:21 PM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class VoidedDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^[0-9]{1,8}$/']),
        ]);
        $metadata->addPropertyConstraints('desMotivoBaja', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
    }
}

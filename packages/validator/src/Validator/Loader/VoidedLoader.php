<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:20 PM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class VoidedLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 5]),
        ]);
        $metadata->addPropertyConstraint('fecGeneracion', new Assert\Date());
        $metadata->addPropertyConstraints('fecComunicacion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('details', new Assert\Valid());
    }
}

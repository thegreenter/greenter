<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 05/10/2017
 * Time: 06:44 PM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CompanyLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('ruc', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^[0-9]{11}$/']),
        ]);
        $metadata->addPropertyConstraints('razonSocial', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
        $metadata->addPropertyConstraint('nombreComercial', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('address', new Assert\Valid());
    }
}

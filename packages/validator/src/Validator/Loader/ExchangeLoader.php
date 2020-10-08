<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:11 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ExchangeLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('monedaRef', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('monedaObj', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraint('factor', new Assert\NotNull());
        $metadata->addPropertyConstraints('fecha', [
            new Assert\NotNull()
        ]);
    }
}

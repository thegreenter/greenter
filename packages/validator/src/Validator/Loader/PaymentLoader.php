<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:55 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class PaymentLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 3, 'max' => 3]),
        ]);
        $metadata->addPropertyConstraint('importe', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fecha', [
            new Assert\NotNull(),
        ]);
    }
}

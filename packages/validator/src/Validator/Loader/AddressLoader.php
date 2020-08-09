<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:17.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class AddressLoader implements LoaderMetadataInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('ubigueo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 6]),
        ]);
        $metadata->addPropertyConstraint('codigoPais', new Assert\Length(['max' => 2]));
        $metadata->addPropertyConstraint('departamento', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('provincia', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('distrito', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('urbanizacion', new Assert\Length(['max' => 25]));
        $metadata->addPropertyConstraint('direccion', new Assert\Length(['max' => 100]));
        $metadata->addPropertyConstraint('codLocal', new Assert\NotBlank());
    }
}

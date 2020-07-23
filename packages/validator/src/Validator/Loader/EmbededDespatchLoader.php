<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 28/09/2017
 * Time: 05:39 PM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class EmbededDespatchLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('llegada', new Assert\Valid());
        $metadata->addPropertyConstraint('partida', new Assert\Valid());
        $metadata->addPropertyConstraint('transportista', new Assert\Valid());
        $metadata->addPropertyConstraint('nroLicencia', new Assert\Length(['max' => 30]));
        $metadata->addPropertyConstraint('transpPlaca', new Assert\Length(['max' => 10]));
        $metadata->addPropertyConstraint('transpCodeAuth', new Assert\Length(['max' => 50]));
        $metadata->addPropertyConstraint('transpMarca', new Assert\Length(['max' => 50]));
        $metadata->addPropertyConstraint('modTraslado', new Assert\Length(['min' => 2, 'max' => 2]));
        $metadata->addPropertyConstraint('pesoBruto', new Assert\Type('numeric'));
        $metadata->addPropertyConstraint('undPesoBruto', new Assert\Length(['max' => 4]));
    }
}

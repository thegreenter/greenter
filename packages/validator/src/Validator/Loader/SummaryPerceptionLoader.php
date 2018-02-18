<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 24/01/2018
 * Time: 11:34 AM
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SummaryPerceptionLoader
 */
class SummaryPerceptionLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('codReg', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'choices' => ['01', '02', '03'],
            ]),
        ]);
        $metadata->addPropertyConstraint('tasa', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoBase', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mto', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoTotal', new Assert\NotBlank());
    }
}
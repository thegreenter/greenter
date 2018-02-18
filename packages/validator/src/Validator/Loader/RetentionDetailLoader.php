<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 11:18 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Greenter\Validator\Constraint as MyAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class RetentionDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 2]),
        ]);
        $metadata->addPropertyConstraints('numDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 13]),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraint('impTotal', new Assert\NotBlank());
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
            new MyAssert\Currency(),
        ]);
        $metadata->addPropertyConstraints('pagos', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('impPagar', new Assert\NotBlank());
        $metadata->addPropertyConstraints('fechaRetencion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraint('impRetenido', new Assert\NotBlank());
        $metadata->addPropertyConstraint('impPagar', new Assert\NotBlank());
        $metadata->addPropertyConstraint('tipoCambio', new Assert\Valid());
    }
}

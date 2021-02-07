<?php

declare(strict_types=1);

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class InvoiceLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoOperacion', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('tipoMoneda', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('totalImpuestos', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('valorVenta', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('mtoImpVenta', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('client', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('formaPago', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('cuotas', new Assert\Valid());
        $metadata->addPropertyConstraint('seller', new Assert\Valid());
        $metadata->addPropertyConstraint('details', new Assert\Valid());
        $metadata->addPropertyConstraint('legends', new Assert\Valid());
        $metadata->addPropertyConstraint('guias', new Assert\Valid());
        $metadata->addPropertyConstraint('anticipos', new Assert\Valid());
        $metadata->addPropertyConstraint('detraccion', new Assert\Valid());
        $metadata->addPropertyConstraint('relDocs', new Assert\Valid());
        $metadata->addPropertyConstraint('perception', new Assert\Valid());
        $metadata->addPropertyConstraint('cargos', new Assert\Valid());
        $metadata->addPropertyConstraint('descuentos', new Assert\Valid());
    }
}
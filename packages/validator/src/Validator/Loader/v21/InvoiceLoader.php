<?php

namespace Greenter\Validator\Loader\v21;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Greenter\Validator\Constraint as MyAssert;
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
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotBlank(),
            new Assert\DateTime(),
        ]);
        $metadata->addPropertyConstraint('fecVencimiento', new Assert\DateTime());
        $metadata->addPropertyConstraints('tipoMoneda', [
            new Assert\NotBlank(),
            new MyAssert\Currency(),
        ]);
        $metadata->addPropertyConstraints('mtoOperGravadas', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperInafectas', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperExoneradas', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperGratuitas', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperExportacion', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperExportacion', [
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('mtoIGV', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoISC', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoBaseIsc', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoOtrosTributos', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoBaseOth', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('mtoDescuentos', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('sumOtrosCargos', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraint('totalAnticipos', new Assert\Type(['type' => 'numeric']));
        $metadata->addPropertyConstraints('totalImpuestos', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('valorVenta', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoImpVenta', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('client', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
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
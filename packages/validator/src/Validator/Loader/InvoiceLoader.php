<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 17/07/2017
 * Time: 10:27 AM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Greenter\Validator\Constraint as MyAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class InvoiceLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'choices' => ['01', '03'], 'message' => '1003'
            ]),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^[F|B][A-Z0-9]{3}$/', 'message' => 'G001']),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^[0-9]{1,8}$/', 'message' => 'G001']),
        ]);
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotBlank(),
            new Assert\DateTime(),
        ]);
        $metadata->addPropertyConstraint('fecVencimiento', new Assert\Date());
        $metadata->addPropertyConstraints('tipoMoneda', [
            new Assert\NotBlank(),
            new MyAssert\Currency(),
        ]);
        $metadata->addPropertyConstraints('mtoOperGravadas', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperInafectas', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoOperExoneradas', [
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
        $metadata->addPropertyConstraint('details', new Assert\Valid());
        $metadata->addPropertyConstraint('legends', new Assert\Valid());
        $metadata->addPropertyConstraint('guias', new Assert\Valid());
        $metadata->addPropertyConstraint('anticipos', new Assert\Valid());
        $metadata->addPropertyConstraint('detraccion', new Assert\Valid());
        $metadata->addPropertyConstraint('relDocs', new Assert\Valid());
        $metadata->addPropertyConstraint('perception', new Assert\Valid());
        $metadata->addPropertyConstraint('guiaEmbebida', new Assert\Valid());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 10:18 AM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class DespatchLoader.
 */
class DespatchLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 2]),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 4]),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 8]),
        ]);
        $metadata->addPropertyConstraint('observacion', new Assert\Length(['max' => 250]));
        $metadata->addPropertyConstraints('fechaEmision', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('destinatario', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('tercero', new Assert\Valid());
        $metadata->addPropertyConstraints('envio', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraint('docBaja', new Assert\Valid());
        $metadata->addPropertyConstraint('relDoc', new Assert\Valid());
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
    }
}

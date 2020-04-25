<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:20 PM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Model\Voided\Voided;
use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class VoidedLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 5]),
        ]);
        $metadata->addPropertyConstraints('fecGeneracion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('fecComunicacion', [
            new Assert\NotBlank(),
            new Assert\Date(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Valid(),
        ]);
        $metadata->addConstraint(new Assert\Callback([$this, 'validate']));
    }

    public function validate($object, ExecutionContextInterface $context)
    {
        /**@var $object Voided */
        if ($object->getFecComunicacion() > new \DateTime()) {
            $context->buildViolation('2301')
                ->atPath('fecComunicacion')
                ->addViolation();
            return;
        }

        if ($object->getFecGeneracion() > $object->getFecComunicacion()) {
            $context->buildViolation('4036')
                ->atPath('fecGeneracion')
                ->addViolation();
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:20.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use DateTime;
use Greenter\Model\Summary\Summary;
use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Greenter\Validator\Constraint as MyAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 5]),
        ]);
        $metadata->addPropertyConstraints('fecGeneracion', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('fecResumen', [
            new Assert\NotNull(),
        ]);
        $metadata->addPropertyConstraints('company', [
            new Assert\NotNull(),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('details', [
            new Assert\NotBlank(),
            new Assert\Count(['min' => 1, 'max' => 500, 'maxMessage' => 'Solo se permite un maximo de 500 items']),
            new Assert\Valid(),
        ]);
        $metadata->addPropertyConstraints('moneda', [
            new Assert\NotBlank(),
            new MyAssert\Currency(),
        ]);
        $metadata->addConstraint(new Assert\Callback([$this, 'validate']));
    }

    public function validate($object, ExecutionContextInterface $context)
    {
        /**@var $object Summary */
        if ($object->getFecResumen() > new DateTime()) {
            $context->buildViolation('2236')
                ->atPath('fecResumen')
                ->addViolation();
            return;
        }

        if ($object->getFecGeneracion() > $object->getFecResumen()) {
            $context->buildViolation('4036')
                ->atPath('fecGeneracion')
                ->addViolation();
        }
    }
}

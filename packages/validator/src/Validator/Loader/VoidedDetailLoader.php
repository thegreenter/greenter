<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 18/07/2017
 * Time: 01:21 PM.
 */

namespace Greenter\Validator\Loader;

use Greenter\Model\Voided\VoidedDetail;
use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class VoidedDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Choice(['choices' => ["01", "07", "08", "14", "20", "40"]]),
        ]);
        $metadata->addPropertyConstraints('serie', [
            new Assert\NotBlank(),
        ]);
        $metadata->addPropertyConstraints('correlativo', [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => '/^[0-9]{1,8}$/']),
        ]);
        $metadata->addPropertyConstraints('desMotivoBaja', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
        $metadata->addConstraint(new Assert\Callback([$this, 'validate']));

    }

    public function validate($object, ExecutionContextInterface $context)
    {
        /** @var $object VoidedDetail */
        $letter = 'F';
        switch ($object->getTipoDoc()) {
            case '20':
                $letter = 'R';
                break;
            case '40':
                $letter = 'P';
                break;
            case '14':
                $letter = 'S';
                break;
        }

        if (!preg_match('/^['.$letter.'][A-Z0-9]{3}$/', $object->getSerie())) {
            $context->buildViolation('2345')
                ->atPath('serie')
                ->addViolation();
        }
    }
}

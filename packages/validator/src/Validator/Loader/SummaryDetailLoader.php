<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:22.
 */

namespace Greenter\Validator\Loader;

use Greenter\Model\Summary\SummaryDetail;
use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(['message' => '2242']),
            new Assert\Choice([
                'choices' => ['03', '07', '08'],
                'message' => '2513'
            ]),
        ]);
        $metadata->addPropertyConstraint('serieNro', new Assert\NotBlank(['message' => '2512']));
        $metadata->addPropertyConstraints('clienteTipo', [
            new Assert\Length(['max' => 1]),
        ]);
        $metadata->addPropertyConstraints('clienteNro', [
            new Assert\Length(['max' => 20]),
        ]);
        $metadata->addPropertyConstraints('estado', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'choices' => [
                    '1', // Adicionar
                    '2', // Modificar
                    '3', // Anulado
                ],
            ]),
        ]);
        $metadata->addPropertyConstraint('docReferencia', new Assert\Valid());
        $metadata->addPropertyConstraint('percepcion', new Assert\Valid());
        $metadata->addPropertyConstraints('total', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraints('mtoIGV', [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
        ]);
        $metadata->addPropertyConstraint('mtoIvap', new Assert\Type(['type' => 'numeric']));
        $metadata->addConstraint(new Assert\Callback([$this, 'validate']));
    }

    public function validate($object, ExecutionContextInterface $context)
    {
        /** @var $object SummaryDetail */
        if (!preg_match('/^[B][A-Z0-9]{3}-[0-9]{1,8}$/', $object->getSerieNro())) {
            $context->buildViolation('2513')
                ->atPath('serieNro')
                ->addViolation();
            return;
        }

        if ($object->getTipoDoc() == '07' || $object->getTipoDoc() == '08') {
            if (empty($object->getDocReferencia())) {
                $context->buildViolation('2512 '.$object->getTipoDoc())
                    ->atPath('docReferencia')
                    ->addViolation();
                return;
            }

            if (!in_array($object->getDocReferencia()->getTipoDoc(), ['03', '12'])) {
                $context->buildViolation('2513')
                    ->atPath('docReferencia')
                    ->addViolation();
            }
        }

        if (!($object->getTotal() > 750)) {
            return;
        }

        if (empty($object->getClienteTipo())) {
            $context->buildViolation('2015')
                ->atPath('clienteTipo')
                ->addViolation();
        }

        if (empty($object->getClienteNro())) {
            $context->buildViolation('2014')
                ->atPath('clienteNro')
                ->addViolation();
        }
    }
}

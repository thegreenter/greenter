<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/07/2017
 * Time: 21:22.
 */

namespace Greenter\Validator\Loader;

use Greenter\Model\Summary\SummaryDetail;
use Greenter\Validator\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SummaryDetailLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Choice([
                'choices' => ['03', '07', '08', '12'],
            ]),
        ]);
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
        $metadata->addPropertyConstraint('total', new Assert\NotBlank());
        $metadata->addPropertyConstraint('mtoIGV', new Assert\NotBlank());

        $callback = function ($object, ExecutionContextInterface $context) {
            /** @var $object SummaryDetail */
            $pattern = $object->getTipoDoc() == '12' ? "/^[a-zA-Z0-9]{1,20}(-[0-9]{1,20})$/" : "/^[B][A-Z0-9]{3}-[0-9]{1,8}$/";
            if (!preg_match($pattern, $object->getSerieNro())) {
                $context->buildViolation('Nro de documento no cumple con el formato para tipo doc. '.$object->getTipoDoc())
                    ->atPath('serieNro')
                    ->addViolation();
            }

            if ($object->getTipoDoc() == '07' || $object->getTipoDoc() == '08') {
                if (empty($object->getDocReferencia())) {
                    $context->buildViolation('Necesita un documento de referencia para tipo doc. '.$object->getTipoDoc())
                        ->atPath('docReferencia')
                        ->addViolation();
                } else if (!in_array($object->getDocReferencia()->getTipoDoc(), ['03', '12'])) {
                    $context->buildViolation('Documento de referencia solo puede ser Ticket(12) o Boleta(03)')
                        ->atPath('docReferencia')
                        ->addViolation();
                }

            }

            if (!($object->getTotal() > 750)) {
                return;
            }

            if (empty($object->getClienteTipo())) {
                $context->buildViolation('Tipo de documento del cliente requerido para ventas mayores a 750')
                    ->atPath('clienteTipo')
                    ->addViolation();
            }

            if (empty($object->getClienteNro())) {
                $context->buildViolation('Numero de documento del cliente requerido para ventas mayores a 750')
                    ->atPath('clienteNro')
                    ->addViolation();
            }
        };

        $metadata->addConstraint(new Assert\Callback($callback));
    }
}

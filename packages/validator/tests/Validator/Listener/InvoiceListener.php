<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/02/2018
 * Time: 18:25
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator\Listener;

use Greenter\Model\Sale\Invoice;
use Greenter\Validator\Metadata\LoaderListenerInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class InvoiceListener implements LoaderListenerInterface
{
    /**
     * @param mixed $value
     * @param ClassMetadata $metadata
     */
    public function onLoaded(object $value, ClassMetadata $metadata)
    {
        if (!($value instanceof Invoice)) {
            return;
        }

        $metadata->addConstraint(new Callback([$this, 'validate']));
    }

    public function validate($object, ExecutionContextInterface $context)
    {
        /** @var $object Invoice */
        $date = $object->getFechaEmision();
        $days = (new \DateTime())->diff($date)->days;

        if ($days > 7) {
            $context->buildViolation('Fecha emision superó 7 dias')
                ->atPath('fechaEmision')
                ->addViolation();
        }
    }
}
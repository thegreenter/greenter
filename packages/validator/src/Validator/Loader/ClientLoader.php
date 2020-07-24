<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/08/2017
 * Time: 23:04.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Class ClientLoader.
 */
class ClientLoader implements LoaderMetadataInterface
{
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraints('tipoDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['min' => 1, 'max' => 1]),
        ]);
        $metadata->addPropertyConstraints('numDoc', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 15]),
        ]);
        $metadata->addPropertyConstraints('rznSocial', [
            new Assert\NotBlank(),
            new Assert\Length(['max' => 100]),
        ]);
        $metadata->addPropertyConstraint('address', new Assert\Valid());
    }
}

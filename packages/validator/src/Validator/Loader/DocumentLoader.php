<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:47.
 */

declare(strict_types=1);

namespace Greenter\Validator\Loader;

use Greenter\Validator\Metadata\LoaderMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DocumentLoader implements LoaderMetadataInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    public function load(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('tipoDoc', new Assert\Length(['min' => 2, 'max' => 2]));
        $metadata->addPropertyConstraint('nroDoc', new Assert\Length(['max' => 30]));
    }
}

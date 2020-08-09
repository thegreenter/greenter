<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:07 PM.
 */

declare(strict_types=1);

namespace Greenter\Validator\Metadata;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface LoaderMetadataInterface.
 */
interface LoaderMetadataInterface
{
    /**
     * @param ClassMetadata $metadata
     */
    public function load(ClassMetadata $metadata);
}

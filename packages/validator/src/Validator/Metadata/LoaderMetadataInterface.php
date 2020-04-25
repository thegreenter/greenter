<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:07 PM.
 */

namespace Greenter\Validator\Metadata;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface LoaderMetadataInterface.
 */
interface LoaderMetadataInterface
{
    /**
     * @param ClassMetadata $metadata.
     */
    public function load(ClassMetadata $metadata);
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/02/2018
 * Time: 18:06
 */

namespace Greenter\Validator\Metadata;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface LoaderListenerInterface
 */
interface LoaderListenerInterface
{
    /**
     * @param mixed $value
     * @param ClassMetadata $metadata
     */
    public function onLoaded($value, ClassMetadata $metadata);
}
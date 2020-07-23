<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 18/02/2018
 * Time: 18:06
 */

declare(strict_types=1);

namespace Greenter\Validator\Metadata;

use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Interface LoaderListenerInterface
 */
interface LoaderListenerInterface
{
    /**
     * @param object $value
     * @param ClassMetadata $metadata
     */
    public function onLoaded(object $value, ClassMetadata $metadata);
}
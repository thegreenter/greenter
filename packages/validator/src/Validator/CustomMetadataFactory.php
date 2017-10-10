<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:38 PM
 */

namespace Greenter\Validator;

use Symfony\Component\Validator\Exception\NoSuchMetadataException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Mapping\MetadataInterface;

/**
 * Class CustomMetadataFactory
 * @package Greenter\Validator
 */
class CustomMetadataFactory implements MetadataFactoryInterface
{
    /**
     * Returns the metadata for the given value.
     *
     * @param mixed $value Some value
     *
     * @return MetadataInterface The metadata for the value
     *
     * @throws NoSuchMetadataException If no metadata exists for the given value
     */
    public function getMetadataFor($value)
    {
        $metaData = new ClassMetadata(get_class($value));
        $fullClass = $this->getClassValidator($value);

        if ($fullClass) {
            /**@var $loader LoaderMetadataInterface */
            $loader = new $fullClass;
            $loader->load($metaData);
        }

        return $metaData;
    }

    /**
     * Returns whether the class is able to return metadata for the given value.
     *
     * @param mixed $value Some value
     *
     * @return bool Whether metadata can be returned for that value
     */
    public function hasMetadataFor($value)
    {
        return !empty($this->getClassValidator($value));
    }

    /**
     * @param $value
     * @return bool|string
     */
    private function getClassValidator($value)
    {
        $className = basename(get_class($value));
        $fullClass = 'Greenter\\Validator\\Loader\\'.$className.'Loader';

        if (!class_exists($fullClass)) {
            return false;
        }

        return $fullClass;
    }
}
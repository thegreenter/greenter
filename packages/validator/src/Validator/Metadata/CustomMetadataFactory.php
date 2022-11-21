<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:38 PM.
 */

namespace Greenter\Validator\Metadata;

use Symfony\Component\Validator\Exception\NoSuchMetadataException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\MetadataFactoryInterface;
use Symfony\Component\Validator\Mapping\MetadataInterface;

/**
 * Class CustomMetadataFactory.
 */
class CustomMetadataFactory implements MetadataFactoryInterface
{
    private $version;

    /**
     * @var LoaderListenerInterface|null
     */
    private $listener;

    /**
     * @param string $version
     */
    public function setVersion(?string $version)
    {
        $this->version = $version;
    }

    /**
     * @param LoaderListenerInterface $listener
     */
    public function setListener(LoaderListenerInterface $listener)
    {
        $this->listener = $listener;
    }

    /**
     * Returns the metadata for the given value.
     *
     * @param mixed $value Some value
     *
     * @return MetadataInterface The metadata for the value
     *
     * @throws NoSuchMetadataException If no metadata exists for the given value
     */
    public function getMetadataFor($value): MetadataInterface
    {
        $metaData = new ClassMetadata(get_class($value));
        $fullClass = $this->getClassValidator($value);

        if ($fullClass === null) {
            return $metaData;
        }

        /** @var LoaderMetadataInterface $loader */
        $loader = new $fullClass();
        $loader->load($metaData);
        if ($this->listener) {
            $this->listener->onLoaded($value, $metaData);
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
    public function hasMetadataFor($value): bool
    {
        return !empty($this->getClassValidator($value));
    }

    /**
     * @param mixed $value
     *
     * @return string|null
     */
    private function getClassValidator($value): ?string
    {
        $classModel = get_class($value);
        $className = substr(strrchr($classModel, '\\'), 1);
        $version = $this->getFormatVersion();
        if (!empty($version)) {
            $fullClass = 'Greenter\\Validator\\Loader\\'.$version.'\\'.$className.'Loader';

            if (class_exists($fullClass)) {
                return $fullClass;
            }
        }
        $fullClass = 'Greenter\\Validator\\Loader\\'.$className.'Loader';

        return class_exists($fullClass) ? $fullClass : null;
    }

    private function getFormatVersion()
    {
        if (empty($this->version)) {
            return '';
        }

        return 'v'.str_replace('.', '', $this->version);
    }
}

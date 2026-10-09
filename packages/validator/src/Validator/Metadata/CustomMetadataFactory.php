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

    private $listener;

    /**
     * Metadata por clase y versión, solo se usa cuando no hay listener.
     *
     * @var array<string, ClassMetadata>
     */
    private $loaded = [];

    public function setVersion(?string $version)
    {
        $this->version = $version;
    }

    public function setListener(LoaderListenerInterface $listener)
    {
        $this->listener = $listener;
        $this->loaded = [];
    }

    public function getMetadataFor($value): MetadataInterface
    {
        $class = $this->getClass($value);
        $key = $class.'@'.$this->getFormatVersion();

        if ($this->listener === null && isset($this->loaded[$key])) {
            return $this->loaded[$key];
        }

        $metaData = new ClassMetadata($class);
        $found = $this->findLoader($class);

        if ($found === null) {
            return $metaData;
        }

        [$ownerClass, $fullClass] = $found;
        $loader = new $fullClass();
        if ($ownerClass === $class) {
            $loader->load($metaData);
        } else {
            // Subclase: las restricciones se definen sobre la clase que declara las propiedades.
            $ownerMetadata = new ClassMetadata($ownerClass);
            $loader->load($ownerMetadata);
            $metaData->mergeConstraints($ownerMetadata);
        }

        if ($this->listener) {
            $this->listener->onLoaded($value, $metaData);

            return $metaData;
        }

        return $this->loaded[$key] = $metaData;
    }

    public function hasMetadataFor($value): bool
    {
        return $this->findLoader($this->getClass($value)) !== null;
    }

    /**
     * Busca el loader de la clase o de la clase padre más cercana.
     *
     * @return string[]|null [clase del modelo con loader, clase del loader]
     */
    private function findLoader(string $classModel): ?array
    {
        $classes = class_exists($classModel)
            ? array_merge([$classModel], array_values(class_parents($classModel)))
            : [$classModel];

        foreach ($classes as $class) {
            $fullClass = $this->getLoaderClass($class);
            if ($fullClass !== null) {
                return [$class, $fullClass];
            }
        }

        return null;
    }

    private function getLoaderClass(string $classModel): ?string
    {
        $className = substr((string)strrchr('\\'.$classModel, '\\'), 1);
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

    /**
     * @param object|string $value
     */
    private function getClass($value): string
    {
        return is_object($value) ? get_class($value) : ltrim((string)$value, '\\');
    }

    private function getFormatVersion()
    {
        if (empty($this->version)) {
            return '';
        }

        return 'v'.str_replace('.', '', $this->version);
    }
}

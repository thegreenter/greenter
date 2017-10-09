<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:36 PM
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;
use Symfony\Component\Validator\Validation;

/**
 * Class SymValidator
 * @package Greenter\Validator
 */
class SymValidator
{
    /**
     * @param DocumentInterface $document
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     * @throws \Exception
     */
    public function validate($document)
    {
        $loader = $this->getLoader($document);
        if ($loader === FALSE) {
            throw new \Exception('Not found loader metadata');
        }

        $metaDataFactory = new CustomMetadataFactory($loader);

        $validator = Validation::createValidatorBuilder()
            ->setMetadataFactory($metaDataFactory)
            ->getValidator();

        return $validator->validate($document);
    }

    /**
     * @param DocumentInterface $document
     * @return bool|LoaderMetadataInterface
     */
    private function getLoader($document)
    {
        $className = basename(get_class($document));
        $fullClass = 'Greenter\\Validator\\Loader\\'.$className.'Loader';

        if (!class_exists($fullClass)) {
            return false;
        }

        return new $$fullClass();
    }
}
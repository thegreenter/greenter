<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:25
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Validator\Metadata\CustomMetadataFactory;
use Symfony\Component\Validator\Validation;

/**
 * Trait CustomValidator
 * @package Tests\Greenter\Validator
 */
trait CustomValidator
{
    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private function getValidator()
    {
        $metaDataFactory = new CustomMetadataFactory();

        return Validation::createValidatorBuilder()
            ->setMetadataFactory($metaDataFactory)
            ->getValidator();
    }
}
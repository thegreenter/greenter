<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:40 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Xml\Builder\CeBuilder;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Symfony\Component\Validator\Validation;

/**
 * Trait CeBuilderTrait
 * @package Tests\Greenter\Xml\Builder
 */
trait CeBuilderTrait
{
    /**
     * @return CeBuilder
     */
    private function getGenerator()
    {
        $generator = new CeBuilder();

        return $generator;
    }

    /**
     * @return Company
     */
    private function getCompany()
    {
        $company = new Company();
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setDireccion('AV GS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }

    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    private function getValidator()
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        return $validator;
    }
}
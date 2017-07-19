<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:40 AM
 */

namespace Tests\Greenter\Xml\Generator;

use Greenter\Xml\Generator\FeGenerator;
use Greenter\Xml\Model\Company\Address;
use Greenter\Xml\Model\Company\Company;
use Symfony\Component\Validator\Validation;

/**
 * Trait FeGeneratorTrait
 * @package tests\Greenter\Xml\Generator
 */
trait FeGeneratorTrait
{
    /**
     * @return FeGenerator
     */
    private function getGenerator()
    {
        $generator = new FeGenerator();
        $generator
            ->setCompany($this->getCompany())
            ->setDirCache(sys_get_temp_dir());

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
            ->setDireccion('AV LS');
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
//        $loader = require __DIR__ . '/../../../../vendor/autoload.php';
//        AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        return $validator;
    }
}
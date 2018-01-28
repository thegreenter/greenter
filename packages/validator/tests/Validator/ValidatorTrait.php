<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:40 PM
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Validator\DocumentValidatorInterface;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Validator\SymfonyValidator;

/**
 * Trait ValidatorTrait
 * @package Tests\Greenter\Validator
 * @method \PHPUnit_Framework_MockObject_MockBuilder getMockBuilder($classname)
 */
trait ValidatorTrait
{
    /**
     * @return DocumentValidatorInterface
     */
    private function getValidator()
    {
        $validator = new SymfonyValidator($this->getCodeProvider());

        return $validator;
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

    private function getCodeProvider()
    {
        $stub = $this->getMockBuilder(ErrorCodeProviderInterface::class)
                ->getMock();

        $stub->method('getValue')
            ->willReturn('');

        /**@var $stub ErrorCodeProviderInterface*/
        return $stub;
    }
}
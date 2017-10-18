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
use Greenter\Validator\SymfonyValidator;

/**
 * Trait ValidatorTrait
 * @package Tests\Greenter\Validator
 */
trait ValidatorTrait
{
    /**
     * @return SymfonyValidator
     */
    private function getValidator()
    {
        $validator = new SymfonyValidator();

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
}
<?php


namespace Tests\Greenter\Validator;

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Validator\DocumentValidatorInterface;
use Greenter\Validator\SymfonyValidator;

trait Validator21Trait
{
    /**
     * @return DocumentValidatorInterface
     */
    private function getValidator()
    {
        $validator = new SymfonyValidator();
        $validator->setVersion('2.1');

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
            ->setDireccion('AV GS')
            ->setCodLocal('00001');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:40 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Validator\DocumentValidatorInterface;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Validator\SymfonyValidator;

/**
 * Trait ValidatorTrait
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
            ->willReturnCallback(function ($code) {
                switch ($code) {
                    case '1003':
                        return 'InvoiceTypeCode - El valor del tipo de documento es invalido o no coincide con el nombre del archivo';
                    case 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.':
                        return 'Este valor es demasiado largo.';
                    default:
                        return '';
                }
            });

        /**@var $stub ErrorCodeProviderInterface*/
        return $stub;
    }
}
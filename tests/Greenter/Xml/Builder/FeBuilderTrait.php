<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:40 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryV2;
use Greenter\Model\Voided\Voided;
use Greenter\Xml\Builder\BuilderInterface;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\SummaryV2Builder;
use Greenter\Xml\Builder\VoidedBuilder;
use Symfony\Component\Validator\Validation;

/**
 * Trait FeBuilderTrait
 * @package tests\Greenter\Xml\Builder
 */
trait FeBuilderTrait
{
    /**
     * @param $className
     * @return BuilderInterface
     */
    private function getGenerator($className)
    {
        $builders = [
          Invoice::class => InvoiceBuilder::class,
          Note::class => NoteBuilder::class,
          Summary::class => SummaryBuilder::class,
          Voided::class => VoidedBuilder::class,
          SummaryV2::class => SummaryV2Builder::class,
        ];
        $builder = new $builders[$className](['cache' => sys_get_temp_dir()]);

        /**@var $builder BuilderInterface */
        return $builder;
    }

    /**
     * @param DocumentInterface $document
     * @return string
     */
    private function build(DocumentInterface $document)
    {
        $generator = $this->getGenerator(get_class($document));

        return $generator->build($document);
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
            ->setUrbanizacion('NINGUNA')
            ->setCodigoPais('PE')
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
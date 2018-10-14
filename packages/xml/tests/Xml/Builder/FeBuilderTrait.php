<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:40 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\StoreTrait;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Voided;
use Greenter\Builder\BuilderInterface;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Xml\Builder\InvoiceBuilder;
use Greenter\Xml\Builder\NoteBuilder;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\VoidedBuilder;

/**
 * Trait FeBuilderTrait
 * @package tests\Greenter\Xml\Builder
 */
trait FeBuilderTrait
{
    use StoreTrait;

    private $builders = [
        Invoice::class => InvoiceBuilder::class,
        Note::class => NoteBuilder::class,
        Summary::class => SummaryBuilder::class,
        Voided::class => VoidedBuilder::class,
        Summary::class => SummaryBuilder::class,
    ];

    /**
     * @param $className
     * @return BuilderInterface
     */
    private function getGenerator($className)
    {
        $builder = new $this->builders[$className]([
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ]);

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
            ->setCodigoPais('PE')
            ->setDistrito('LIMA')
            ->setUrbanizacion('-')
            ->setDireccion('AV LS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:40 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;
use Greenter\Builder\BuilderInterface;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Xml\Builder\DespatchBuilder;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use Greenter\Xml\Builder\VoidedBuilder;

/**
 * Trait CeBuilderTrait
 * @package Tests\Greenter\Xml\Builder
 */
trait CeBuilderTrait
{
    /**
     * @param string $className
     * @return BuilderInterface
     */
    private function getGenerator($className)
    {
        $builders = [
            Despatch::class => DespatchBuilder::class,
            Perception::class => PerceptionBuilder::class,
            Retention::class => RetentionBuilder::class,
            Reversion::class => VoidedBuilder::class,
        ];
        $builder = new $builders[$className](['cache' => false, 'strict_variables' => true]);

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
            ->setDistrito('LIMA')
            ->setDireccion('AV GS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }


    private function createExtensionContent(\DOMDocument $document)
    {
        $childs = $document->documentElement->getElementsByTagNameNS('urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2','ExtensionContent');
        if ($childs->length > 0) {
            $element = $document->createElementNS('urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2','cbc:AccountID', 1);
            $childs->item(0)->appendChild($element);
        }
    }
}
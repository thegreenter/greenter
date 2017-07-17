<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Generator;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Greenter\Xml\Model\Sale\Invoice;
use Greenter\Xml\Model\Sale\SaleDetail;
use Symfony\Component\Validator\Validation;

/**
 * Class FeGeneratorTest
 * @package Tests\Greenter\Xml\Generator
 */
class FeGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateInvoice()
    {
        AnnotationRegistry::registerAutoloadNamespace("Symfony\Component\Validator\Constraint",
            'B:\\Giancarlos\\Documentos\\www\\greenter\\vendor\\symfony\\validator');
        $invoice = $this->getInvoice();

        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $errors = $validator->validate($invoice);

        $this->assertTrue($errors->count() == 0);
    }

    private function getInvoice()
    {
        $invoice = new Invoice();
        $invoice->setTipoDoc('01')
        ->setSerie('F001')
        ->setCorrelativo('123')
        ->setTipoMoneda('PEN')
        ->setTipoDocUsuario('6')
        ->setNumDocUsuario('20000000001')
        ->setRznSocialUsuario('EMPRESA 1')
        ->setMtoOperGravadas(200)
        ->setMtoOperExoneradas(0)
        ->setMtoOperInafectas(0)
        ->setMtoIGV(36)
        ->setMtoImpVenta(236);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C01')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(100)
            ->setTipAfeIgv('10')
            ->setMtoValorUnitario(50);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C01')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(100)
            ->setTipAfeIgv('10')
            ->setMtoValorUnitario(50);

        $invoice->setDetails([$detail1, $detail2]);

        return $invoice;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Generator;

use Greenter\Xml\Generator\FeGenerator;
use Greenter\Xml\Model\Company\Address;
use Greenter\Xml\Model\Company\Company;
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
//        $loader = require __DIR__ . '/../../../../vendor/autoload.php';
//
//        AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
        $invoice = $this->getInvoice();

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($invoice);

        $this->assertTrue($errors->count() == 0);
    }

    public function testCreateXmlInvoice()
    {
        $invoice = $this->getInvoice();

        $generator = new FeGenerator();
        $generator
            ->setCompany($this->getCompany())
            ->setDirCache(sys_get_temp_dir());
        $xml = $generator->buildFact($invoice);

        $this->assertNotEmpty($xml);
        $this->assertInvoiceXml($xml);
        // file_put_contents('invoice.xml', $xml);
    }

    private function assertInvoiceXml($xml)
    {
        $expec = new \DOMDocument();
        $expec->load(__DIR__.'/../../Resources/invoice.xml');
        $actual = new \DOMDocument();
        $actual->loadXML($xml);

        @$sXml = new \SimpleXMLElement($xml);
        $sXml->registerXPathNamespace('xs', 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');
        $id = $sXml->xpath('/xs:Invoice/cbc:ID');
        $lines = $sXml->xpath('//cac:InvoiceLine');
        $this->assertEquals(1, count($id));
        $this->assertEquals('F001-123', $id[0]);
        $this->assertEquals(2, count($lines));
        $this->assertEqualXMLStructure($expec->documentElement, $actual->documentElement);
        //$this->assertXmlStringEqualsXmlFile(__DIR__.'/../../Resources/invoice.xml', $xml);
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
        $detail1->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVentaItem(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioVentaItem(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVentaItem(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioVentaItem(56);

        $invoice->setDetails([$detail1, $detail2]);

        return $invoice;
    }

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
}
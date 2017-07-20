<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Generator;

use Greenter\Xml\Model\Sale\Invoice;
use Greenter\Xml\Model\Sale\Legend;
use Greenter\Xml\Model\Sale\SaleDetail;

/**
 * Class FeInvoiceGeneratorTest
 * @package Tests\Greenter\Xml\Generator
 */
class FeInvoiceGeneratorTest extends \PHPUnit_Framework_TestCase
{
    use FeGeneratorTrait;

    public function testValidateInvoice()
    {
        $invoice = $this->getInvoice();
        $validator = $this->getValidator();
        $errors = $validator->validate($invoice);

        $this->assertEquals(0,$errors->count());
    }

    public function testNotValidInvoice()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoDoc('123')
            ->setSerie('FF000');

        $validator = $this->getValidator();
        $errors = $validator->validate($invoice);

        $this->assertEquals(2,$errors->count());
    }

    public function testCreateXmlInvoice()
    {
        $invoice = $this->getInvoice();

        $generator = $this->getGenerator();
        $xml = $generator->buildInvoice($invoice);

        $this->assertNotEmpty($xml);
        $this->assertInvoiceXml($xml);
        file_put_contents('invoice.xml', $xml);
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
        $detail1->setCodProducto('C023')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $invoice->setDetails([$detail1, $detail2])
            ->setLegends([$legend]);

        return $invoice;
    }
}
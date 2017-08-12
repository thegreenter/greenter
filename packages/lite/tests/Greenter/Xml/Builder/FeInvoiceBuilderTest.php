<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

/**
 * Class FeInvoiceBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeInvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;

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

        // file_put_contents('x.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertInvoiceXml($xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testCreateXmlInvoiceException()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoDoc('333')
            ->setSerie('FF000');

        $generator = $this->getGenerator();
        $generator->buildInvoice($invoice);
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

    public function testInvoiceFilename()
    {
        $ruc = $this->getCompany()->getRuc();
        $invoice = $this->getInvoice();
        $filename = $invoice->getFileName($ruc);

        $this->assertEquals($this->getFilename($invoice, $ruc), $filename);
    }

    private function getFileName(Invoice $invoice, $ruc)
    {
        $parts = [
            $ruc,
            $invoice->getTipoDoc(),
            $invoice->getSerie(),
            $invoice->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    private function getInvoice()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');
        $perc = new SalePerception();
        $perc->setCodReg('01')
            ->setMto(2)
            ->setMtoBase(3)
            ->setMtoTotal(4);

        $invoice = new Invoice();
        $invoice
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setTipoOperacion('2')
            ->setPerception($perc)
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoImpVenta(236);

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 1')
            ->setMtoIgvItem(18)
            ->setMtoIscItem(3)
            ->setTipSisIsc('3')
            ->setMtoValorGratuito(12)
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
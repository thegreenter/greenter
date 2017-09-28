<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

/**
 * Class FeInvoiceBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeInvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;

    /**
     * @after testCompanyValidate
     */
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

    public function testCompanyValidate()
    {
        $company = $this->getCompany();
        $adress = $company->getAddress();

        $this->assertNotNull($company->getAddress());
        $this->assertNotEmpty($company->getNombreComercial());
        $this->assertNotEmpty($company->getRazonSocial());
        $this->assertNotEmpty($company->getRuc());
        $this->assertNotEmpty($adress->getDepartamento());
        $this->assertNotEmpty($adress->getProvincia());
        $this->assertNotEmpty($adress->getDistrito());
        $this->assertNotEmpty($adress->getUrbanizacion());
    }

    public function testInvoiceFilename()
    {
        $invoice = $this->getInvoice();
        $filename = $invoice->getFileName();

        $this->assertEquals($this->getFilename($invoice), $filename);
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

    private function getFileName(Invoice $invoice)
    {
        $parts = [
            $invoice->getCompany()->getRuc(),
            $invoice->getTipoDoc(),
            $invoice->getSerie(),
            $invoice->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    private function getInvoice()
    {
        $invoice = new Invoice();
        $invoice
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setTipoOperacion('2')
            ->setPerception((new SalePerception())
                ->setCodReg('01')
                ->setMto(2)
                ->setMtoBase(3)
                ->setMtoTotal(4)
            )->setGuia((new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-1')
            )->setCompra('001-12112')
            ->setDetraccion((new Detraction())
                ->setMount(2228.3)
                ->setPercent(9)
                ->setValueRef(2000)
            )->setAnticipo((new Prepayment())
                    ->setTotal(100)
                    ->setNroDocEmisor('20000000001')
                    ->setTipoDocEmisor('6')
                    ->setTipoDocRel('02')
                    ->setNroDocRel('F001-21'))
            ->setRelDocs([(new Document())
                ->setTipoDoc('01')
                ->setNroDoc('F001-123')
            ])
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000001')
                ->setRznSocial('EMPRESA 1')
            )->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany())
            ->setDetails([(new SaleDetail())
            ->setCodProducto('C023')
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
            ->setMtoPrecioUnitario(56)
            , (new SaleDetail())
            ->setCodProducto('C02')
            ->setCodUnidadMedida('NIU')
            ->setCtdUnidadItem(2)
            ->setDesItem('PROD 2')
            ->setMtoDsctoItem(1)
            ->setMtoIgvItem(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(10)
            ->setMtoValorGratuito(2)
            ->setMtoPrecioUnitario(0)
        ])->setLegends([
            (new Legend())
            ->setCode('1000')
            ->setValue('SON N SOLES')
        ]);

        return $invoice;
    }
}
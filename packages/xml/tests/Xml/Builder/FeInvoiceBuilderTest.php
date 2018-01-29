<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Sale\Invoice;

/**
 * Class FeInvoiceBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeInvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlInvoice()
    {
        $invoice = $this->getInvoice();
        $xml = $this->build($invoice);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);

//        file_put_contents('x.xml', $xml);
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
        $filename = $invoice->getName();

        $this->assertEquals($this->getFilename($invoice), $filename);
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
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 22:54
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\Generator\InvoiceStore;
use Greenter\Model\Sale\Invoice;
use PHPUnit\Framework\TestCase;

/**
 * Class FeInvoiceBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeInvoiceBuilderTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlInvoice()
    {
        $invoice = $this->createDocument(InvoiceFullStore::class);

        $xml = $this->build($invoice);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testInvoiceFilename()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceStore::class);
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
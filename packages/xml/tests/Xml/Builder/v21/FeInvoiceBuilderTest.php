<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 11/10/2018
 * Time: 18:05
 */

namespace Tests\Greenter\Xml\Builder\v21;

use Greenter\Data\Generator\InvoiceDiscountStore;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Model\Sale\Invoice;
use Tests\Greenter\Xml\Builder\FeBuilderTrait;
use Tests\Greenter\Xml\Builder\XsdValidatorTrait;

class FeInvoiceBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testGenerate()
    {
        /**@var $invoice Invoice*/
        $invoice = $this->createDocument(InvoiceFullStore::class);
        $invoice->setUblVersion('2.1');

        $xml = $this->build($invoice);

//        file_put_contents('x.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testInvoiceWithDiscount()
    {
        $invoice = $this->createDocument(InvoiceDiscountStore::class);

        $xml = $this->build($invoice);
        //        file_put_contents('x.xml', $xml);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }
}
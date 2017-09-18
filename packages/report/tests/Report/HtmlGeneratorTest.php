<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 21:58
 */

namespace Tests\Greenter\Report;

/**
 * Class HtmlGeneratorTest
 * @package Tests\Greenter\Report
 */
class HtmlGeneratorTest extends \PHPUnit_Framework_TestCase
{
    use HtmlGeneratorTrait;

    public function testCreatePdf()
    {
        $generator = $this->getGenerator();
        $invoice = $this->getInvoice();

        $pdfRaw = $generator->build($invoice);

        $this->assertNotEmpty($pdfRaw);
    }
}

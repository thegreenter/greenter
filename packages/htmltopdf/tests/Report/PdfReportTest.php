<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 20/01/2018
 * Time: 18:57
 */

namespace Tests\Greenter\Report;

use Greenter\Model\Sale\Invoice;
use Greenter\Report\PdfReport;
use Greenter\Report\ReportInterface;

/**
 * Class PdfReportTest
 * @package Tests\Greenter\Report
 */
class PdfReportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PdfReport
     */
    private $pdf;

    protected function setUp()
    {
        $htmlRender = $this->getHtmlRender();
        $this->pdf = new PdfReport($htmlRender);
        $this->pdf->setOptions([
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'viewport-size' => '1280x1024',
        ]);
        $this->pdf->getExporter()->tmpDir = __DIR__.'/../Resources';

        $this->pdf->setBinPath($this->isWindows()
            ? __DIR__.'/../../wkhtmltopdf.exe'
            : 'wkhtmltopdf');
    }

    public function testPdfRender()
    {
        $invoice = $this->getInvoice();

        $content = $this->pdf->render($invoice);

        $this->assertNotEmpty($content);
        $this->assertNotEmpty($this->pdf->getHtml());

        if ($this->isWindows()) {
            $path = __DIR__.DIRECTORY_SEPARATOR.'report.pdf';
            file_put_contents($path, $content);

            exec('start '.$path);
        }
    }

    public function testPdfRenderWithBreak()
    {
        $invoice = $this->getInvoice();

        $content = $this->pdf->render($invoice, ['name' => 'invoiceBreak.html']);

        $this->assertNotEmpty($content);

        if ($this->isWindows()) {
            $path = __DIR__.DIRECTORY_SEPARATOR.'report2Pages.pdf';
            file_put_contents($path, $content);

            exec('start '.$path);
        }
    }

    /**
     * @return ReportInterface
     */
    private function getHtmlRender()
    {
        $stub = $this->getMockBuilder(ReportInterface::class)
                ->getMock();

        $stub->method('render')
                ->willReturnCallback(function ($doc, $params) {
                    $filename = 'invoice.html';
                    if (isset($params['name'])) {
                        $filename = $params['name'];
                    }

                    return file_get_contents(__DIR__ . '/../Resources/'.$filename);
                });

        /**@var $stub ReportInterface*/
        return $stub;
    }

    private function getInvoice()
    {
        return new Invoice();
    }

    private function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}
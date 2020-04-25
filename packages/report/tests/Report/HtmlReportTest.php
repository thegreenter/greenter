<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

namespace Tests\Greenter\Report;

use Greenter\Data\Generator\DespatchStore;
use Greenter\Data\Generator\InvoiceStore;
use Greenter\Data\Generator\NoteStore;
use Greenter\Data\Generator\PerceptionStore;
use Greenter\Data\Generator\RetentionStore;
use Greenter\Data\Generator\ReversionStore;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Data\Generator\VoidedStore;
use Greenter\Model\DocumentInterface;
use PHPUnit\Framework\TestCase;

class HtmlReportTest extends TestCase
{
    use HtmlReportTrait;
    use SharedBuilderTrait;

    /**
     * @dataProvider provideDocs
     * @param DocumentInterface $document
     */
    public function testGenInvoiceReport(DocumentInterface $document)
    {
        $report = $this->getReporter();
        $report->setTemplate('invoice.html.twig');

        $html = $report->render($document, $this->getParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenReportOtherTemplate()
    {
        $report = $this->getReporter();
        $inv = $this->createDocument(InvoiceStore::class);
        $report->setTemplate('invoice2.html.twig');

        $html = $report->render($inv, $this->getParamters());
        $this->assertNotEmpty($html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenVoidedReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('voided.html.twig');

        $document = $this->createDocument(VoidedStore::class);
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function testGenReversionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('voided.html.twig');

        $document = $this->createDocument(ReversionStore::class);
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function testGenSummaryReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('summary.html.twig');

        $document = $this->createDocument(SummaryStore::class);
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function testGenRetentionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('retention.html.twig');

        $document = $this->createDocument(RetentionStore::class);
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function testGenPerceptionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('perception.html.twig');

        $document = $this->createDocument(PerceptionStore::class);
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function testGenDespatchReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('despatch.html.twig');

        $document = $this->createDocument(DespatchStore::class);
        $parameters = $this->getDefaultParamters();
        unset($parameters['user']['footer']);
        $html = $report->render($document, $parameters);
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function provideDocs()
    {
        return [
          [$this->createDocument(InvoiceStore::class)],
          [$this->createDocument(NoteStore::class)]
        ];
    }

    private function getParamters()
    {
        $logo = file_get_contents(__DIR__.'/../Resources/logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => 'xkhakjjuui293/=33w',
            ],
            'user' => [
                'numIGV' => 18,
                'resolucion' => '212321',
                'header' => 'Telf: <b>(056) 123375</b>',
                'extras' => [
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
                'footer' => file_get_contents(__DIR__.'/../Resources/footer.html'),
            ]
        ];
    }
}
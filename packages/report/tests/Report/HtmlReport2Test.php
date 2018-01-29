<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

namespace Tests\Greenter\Report;

use Greenter\Data\StoreTrait;
use Greenter\Model\DocumentInterface;

class HtmlReport2Test extends \PHPUnit_Framework_TestCase
{
    use HtmlReportTrait;
    use StoreTrait;

    /**
     * @dataProvider provideDocs
     * @param DocumentInterface $document
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
    public function testGenVoidedReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('voided.html.twig');

        $document = $this->getVoided();
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenReversionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('voided.html.twig');

        $document = $this->getReversion();
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenSummaryReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('summary.html.twig');

        $document = $this->getSummary();
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenRetentionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('retention.html.twig');

        $document = $this->getRetention();
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenPerceptionReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('perception.html.twig');

        $document = $this->getPerception();
        $html = $report->render($document, $this->getDefaultParamters());
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenDespatchReport()
    {
        $report = $this->getReporter();
        $report->setTemplate('despatch.html.twig');

        $document = $this->getDespatch();
        $parameters = $this->getDefaultParamters();
        unset($parameters['user']['footer']);
        $html = $report->render($document, $parameters);
        $this->assertNotEmpty($html);
        $this->showResult($document->getName(), $html);
    }

    public function provideDocs()
    {
        return [
          [$this->getInvoice()],
          [$this->getNote()]
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
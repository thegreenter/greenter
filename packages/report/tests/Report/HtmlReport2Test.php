<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

namespace Tests\Greenter\Report;

use Greenter\Model\DocumentInterface;

class HtmlReport2Test extends \PHPUnit_Framework_TestCase
{
    use HtmlReportTrait;

    /**
     * @dataProvider provideDocs
     * @param DocumentInterface $document
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function testGenReport(DocumentInterface $document)
    {
        $report = $this->getReporter();
        $report->setTemplate('invoice2.html.twig');

        $html = $report->render($document, $this->getParamters());
        $this->assertNotEmpty($html);

//        file_put_contents($document->getName().'.html', $html);
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
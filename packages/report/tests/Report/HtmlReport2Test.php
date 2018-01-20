<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

namespace Tests\Greenter\Report;

class HtmlReport2Test extends \PHPUnit_Framework_TestCase
{
    use HtmlReportTrait;

    public function testGenReport()
    {
        $report = $this->getReporter();
        $inv = $this->getInvoice();
        $report->setTemplate('invoice2.html.twig');

        try {
            $html = $report->render($inv, $this->getParamters());
            $this->assertNotEmpty($html);
        } catch (\Exception $e) {
            echo $e->getMessage();
            $this->assertTrue(false);
        }
//        file_put_contents('file2.html', $html);
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
                'dir_client' => 'AV ITALIA 23423',
                'extras' => [
                    ['name' => 'CONDICION DE PAGO', 'value' => 'Efectivo'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
                'footer' => file_get_contents(__DIR__.'/../Resources/footer.html'),
            ]
        ];
    }
}
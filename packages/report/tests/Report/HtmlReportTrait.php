<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 02:21 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Report;

use Greenter\Report\HtmlReport;

trait HtmlReportTrait
{
    /**
     * @return HtmlReport
     */
    private function getReporter()
    {
        $report = new HtmlReport(__DIR__.'/../Resources', ['cache' => false, 'strict_variables' => true]);
        $report->getTwig()->addGlobal('max_items', 7);

        return $report;
    }

    private function getDefaultParamters()
    {
        $logo = file_get_contents(__DIR__.'/../Resources/logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => 'xkhakjjuui293/=33w',
            ],
            'user' => [
                'header' => 'Telf: <b>(056) 123375</b>',
                'footer' => file_get_contents(__DIR__.'/../Resources/footer.html'),
            ]
        ];
    }

    private function showResult($name, $hml)
    {
//      file_put_contents($name.'.html', $hml);
    }
}

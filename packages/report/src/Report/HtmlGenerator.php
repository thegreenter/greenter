<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 21:55
 */

namespace Greenter\Report;

use Greenter\Report\Model\Invoice;
use mikehaertl\wkhtmlto\Pdf;

/**
 * Class HtmlGenerator
 * @package Greenter\Report
 */
class HtmlGenerator implements PdfGenerator
{
    /**
     * @var string
     */
    private $dirCache;

    /**
     * @var string
     */
    private $binWkhtml;

    /**
     * HtmlGenerator constructor.
     */
    public function __construct()
    {
        $this->dirCache = sys_get_temp_dir();
    }

    /**
     * Generate Pdf from Invoice.
     *
     * @param Invoice $invoice
     * @return mixed
     */
    public function build(Invoice $invoice)
    {
        $twig = $this->getRender();
        $html = $twig->render('invoice.html.twig', ['doc' => $invoice]);

        return $this->getPdf($html);
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        if (isset($parameters['cache'])) {
            $this->dirCache = $parameters['cache'];
        }
        if (isset($parameters['wkhtml_bin'])) {
            $this->binWkhtml = $parameters['wkhtml_bin'];
        }
    }

    /**
     * @param $html
     * @return bool|string
     */
    private function getPdf($html)
    {
        $pdf = new Pdf([
            'no-outline', // Make Chrome not complain
            //'viewport-size' => '1280x1024',
            //'page-width' => '21cm',
            //'page-height' => '29cm'
        ]);
        $pdf->addPage($html);
        $pdf->binary = $this->binWkhtml;

        return $pdf->toString();
    }

    private function getRender()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/Templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => $this->dirCache,
        ));

        return $twig;
    }
}
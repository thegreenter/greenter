<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 20/01/2018
 * Time: 18:36.
 */

namespace Greenter\Report;

use Greenter\Model\DocumentInterface;
use mikehaertl\wkhtmlto\Pdf;

/**
 * Class PdfReport.
 */
class PdfReport implements ReportInterface
{
    /**
     * @var ReportInterface
     */
    private $htmlReport;

    /**
     * @var Pdf
     */
    private $pdfRender;

    /**
     * PdfReport constructor.
     *
     * @param ReportInterface $htmlReport
     */
    public function __construct(ReportInterface $htmlReport)
    {
        $this->htmlReport = $htmlReport;
        $this->pdfRender = new Pdf([
            'no-outline', // Make Chrome not complain
            'viewport-size' => '1280x1024',
        ]);
    }

    /**
     * @param DocumentInterface $document
     * @param array             $parameters
     *
     * @return mixed
     */
    public function render(DocumentInterface $document, $parameters = [])
    {
        $html = $this->htmlReport->render($document, $parameters);

        return $this->buildPdf($html);
    }

    public function setOptions(array $options)
    {
        $this->pdfRender->setOptions($options);
    }

    /**
     * @param string $path
     */
    public function setBinPath($path)
    {
        $this->pdfRender->binary = $path;
    }

    private function buildPdf($html)
    {
        $this->pdfRender->addPage($html);

        return $this->pdfRender->toString();
    }
}

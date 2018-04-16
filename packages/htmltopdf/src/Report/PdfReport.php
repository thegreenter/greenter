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
     * @var string
     */
    private $html;

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
        ]);
    }

    /**
     * Return last html generated.
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * @param DocumentInterface $document
     * @param array             $parameters
     *
     * @return mixed
     */
    public function render(DocumentInterface $document, $parameters = [])
    {
        $this->html = $this->htmlReport->render($document, $parameters);

        return $this->buildPdf($this->html);
    }

    /**
     * Pdf Options.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->pdfRender->setOptions($options);
    }

    /**
     * @return Pdf
     */
    public function getExporter()
    {
        return $this->pdfRender;
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

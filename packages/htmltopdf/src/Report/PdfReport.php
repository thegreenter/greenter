<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 20/01/2018
 * Time: 18:36.
 */

declare(strict_types=1);

namespace Greenter\Report;

use Greenter\Model\DocumentInterface;
use mikehaertl\wkhtmlto\Pdf;
use phpDocumentor\Reflection\Types\Boolean;

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
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * @param DocumentInterface $document
     * @param array             $parameters
     *
     * @return string
     */
    public function render(DocumentInterface $document, array $parameters = []): ?string
    {
        $this->html = $this->htmlReport->render($document, $parameters);

        return $this->buildPdf($this->html);
    }

    /**
     * Pdf Options.
     *
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        $this->pdfRender->setOptions($options);
    }

    /**
     * @return Pdf
     */
    public function getExporter(): ?Pdf
    {
        return $this->pdfRender;
    }

    /**
     * @param string $path
     */
    public function setBinPath(?string $path): void
    {
        $this->pdfRender->binary = $path;
    }

    private function buildPdf(?string $html): ?string
    {
        $this->pdfRender->addPage($html);

        $result = $this->pdfRender->toString();

        return $result === false ? null : (string)$result;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 21:55.
 */

namespace Greenter\Report;

use Greenter\Model\DocumentInterface;
use Greenter\Report\Extension\ReportTwigExtension;
use Greenter\Report\Extension\RuntimeLoader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class HtmlReport.
 */
class HtmlReport implements ReportInterface
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $template = 'invoice.html.twig';

    /**
     * HtmlReport constructor.
     *
     * @param string $templatesDir
     * @param array  $optionTwig
     */
    public function __construct($templatesDir = '', $optionTwig = [])
    {
        if (!isset($optionTwig['autoescape'])) {
            $optionTwig['autoescape'] = false;
        }

        $this->twig = $this->buildTwig($templatesDir, $optionTwig);
    }

    /**
     * Build html report.
     *
     * @param DocumentInterface $document
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(DocumentInterface $document, $parameters = [])
    {
        $html = $this->twig->render($this->template, [
            'doc' => $document,
            'params' => $parameters,
        ]);

        return $html;
    }

    /**
     * Set filename templte.
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param $directory
     * @param $options
     *
     * @return Environment
     */
    private function buildTwig($directory, $options)
    {
        $dirs = $this->getDirectories($directory);

        $loader = new FilesystemLoader($dirs);
        $twig = new Environment($loader, $options);

        $twig->addRuntimeLoader(new RuntimeLoader());
        $twig->addExtension(new ReportTwigExtension());

        return $twig;
    }

    /**
     * @param $directory
     *
     * @return array
     */
    private function getDirectories($directory)
    {
        $dirs = [];
        if ($directory) {
            $dirs[] = $directory;
        }
        $dirs[] = __DIR__.'/Templates';

        return $dirs;
    }
}

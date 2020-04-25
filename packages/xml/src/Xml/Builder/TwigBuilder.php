<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:23.
 */

namespace Greenter\Xml\Builder;

use Greenter\Xml\Filter\FormatFilter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

/**
 * Class TwigBuilder.
 */
class TwigBuilder
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * TwigBuilder constructor.
     *
     * @param array $options [optional] Recommended: 'cache' => '/dir/cache'
     */
    public function __construct($options = [])
    {
        $this->initTwig($options);
    }

    /**
     * Get Content XML from template.
     *
     * @param string $template
     * @param object $doc
     *
     * @return string
     */
    public function render($template, $doc)
    {
        return $this->twig->render($template, [
            'doc' => $doc,
        ]);
    }

    private function initTwig($options)
    {
        $loader = new FilesystemLoader(__DIR__.'/../Templates');

        $twig = new Environment($loader, $options);
        $this->LoadFilterAndFunctions($twig);

        $this->twig = $twig;
    }

    /**
     * @param Environment $twig
     */
    private function LoadFilterAndFunctions(Environment $twig)
    {
        $formatFilter = new FormatFilter();

        $twig->addFilter(new TwigFilter('n_format', [$formatFilter, 'number']));
        $twig->addFilter(new TwigFilter('n_format_limit', [$formatFilter, 'numberLimit']));
    }
}

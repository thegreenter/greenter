<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:23.
 */

namespace Greenter\Xml\Builder;

use Greenter\Xml\Filter\FormatFilter;
use Greenter\Xml\Filter\TributoFunction;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Class TwigBuilder.
 */
class TwigBuilder
{
    /**
     * @var Twig_Environment
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
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($template, $doc)
    {
        return $this->twig->render($template, [
            'doc' => $doc,
        ]);
    }

    private function initTwig($options)
    {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/../Templates');

        $twig = new Twig_Environment($loader, $options);
        $this->LoadFilterAndFunctions($twig);

        $this->twig = $twig;
    }

    /**
     * @param Twig_Environment $twig
     */
    private function LoadFilterAndFunctions(Twig_Environment $twig)
    {
        $formatFilter = new FormatFilter();

        $twig->addFilter(new Twig_SimpleFilter('n_format', [$formatFilter, 'number']));
        $twig->addFilter(new Twig_SimpleFilter('n_format_limit', [$formatFilter, 'numberLimit']));
        $twig->addFunction(new Twig_SimpleFunction('getTributoAfect', [TributoFunction::class, 'getByAfectacion']));
    }
}

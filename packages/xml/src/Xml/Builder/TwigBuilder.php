<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:23
 */

namespace Greenter\Xml\Builder;

/**
 * Class TwigBuilder
 * @package Greenter\Xml\Builder
 */
class TwigBuilder
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * TwigBuilder constructor.
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
     * @return string
     */
    public function render($template, $doc)
    {
        return $this->twig->render($template, [
            'doc' => $doc
        ]);
    }

    private function initTwig($options)
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $numFilter = new \Twig_SimpleFilter('n_format', function ($number, $decimals = 2) {
            return number_format($number, $decimals, '.', '');
        });
        $twig = new \Twig_Environment($loader, $options);
        $twig->addFilter($numFilter);

        $this->twig = $twig;
    }
}
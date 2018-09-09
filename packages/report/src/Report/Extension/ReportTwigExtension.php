<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:45 PM.
 */

namespace Greenter\Report\Extension;

/**
 * Class ReportTwigExtension.
 */
class ReportTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('catalog', ['Greenter\Report\Filter\DocumentFilter', 'getValueCatalog']),
            new \Twig_SimpleFilter('image_b64', ['Greenter\Report\Filter\ImageFilter', 'toBase64']),
            new \Twig_SimpleFilter('n_format', ['Greenter\Report\Filter\FormatFilter', 'number']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('legend', ['Greenter\Report\Filter\ResolveFilter', 'getValueLegend']),
            new \Twig_SimpleFunction('qrCode', ['Greenter\Report\Render\QrRender', 'getImage']),
        ];
    }
}

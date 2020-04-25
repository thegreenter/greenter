<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:45 PM.
 */

namespace Greenter\Report\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class ReportTwigExtension.
 */
class ReportTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('catalog', ['Greenter\Report\Filter\DocumentFilter', 'getValueCatalog']),
            new TwigFilter('image_b64', ['Greenter\Report\Filter\ImageFilter', 'toBase64']),
            new TwigFilter('n_format', ['Greenter\Report\Filter\FormatFilter', 'number']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('legend', ['Greenter\Report\Filter\ResolveFilter', 'getValueLegend']),
            new TwigFunction('qrCode', ['Greenter\Report\Render\QrRender', 'getImage']),
        ];
    }
}

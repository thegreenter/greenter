<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:45 PM.
 */

namespace Greenter\Report\Extension;

use Greenter\Report\Filter\DocumentFilter;
use Greenter\Report\Filter\FormatFilter;
use Greenter\Report\Filter\ImageFilter;
use Greenter\Report\Filter\ResolveFilter;

/**
 * Class ReportTwigExtension.
 */
class ReportTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('doc_name', DocumentFilter::class.'::getNameDoc'),
            new \Twig_SimpleFilter('symbol_money', DocumentFilter::class.'::getSymbolCurrency'),
            new \Twig_SimpleFilter('name_money', DocumentFilter::class.'::getNameCurrency'),
            new \Twig_SimpleFilter('symbol_docident', DocumentFilter::class.'::getSymbolDocIdentidad'),
            new \Twig_SimpleFilter('image_b64', ImageFilter::class.'::toBase64'),
            new \Twig_SimpleFilter('n_format', FormatFilter::class.'::number'),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('legend', ResolveFilter::class.'::getValueLegend'),
            new \Twig_SimpleFunction('qrCode', ResolveFilter::class.'::getQr'),
        ];
    }
}

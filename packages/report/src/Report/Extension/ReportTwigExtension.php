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
use Greenter\Report\Render\QrRender;
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
            new TwigFilter('catalog', [new DocumentFilter(), 'getValueCatalog']),
            new TwigFilter('image_b64', [new ImageFilter(), 'toBase64']),
            new TwigFilter('n_format', [new FormatFilter(), 'number']),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('legend', [new ResolveFilter(), 'getValueLegend']),
            new TwigFunction('qrCode', [new QrRender(), 'getImage']),
            new TwigFunction('qrCodeDespatch', [new QrRender(), 'getImageDespatch']),
            new TwigFunction('qrUrl', [new QrRender(), 'getQrUrl']),
        ];
    }
}

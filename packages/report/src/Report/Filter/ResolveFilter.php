<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 01:47 PM.
 */

namespace Greenter\Report\Filter;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Greenter\Model\Sale\BaseSale;
use Greenter\Model\Sale\Legend;

/**
 * Class ResolveFilter
 */
class ResolveFilter
{
    /**
     * @param Legend[] $legends
     * @param $code
     *
     * @return string
     */
    public function getValueLegend($legends, $code)
    {
        foreach ($legends as $legend) {
            if ($legend->getCode() == $code) {
                return $legend->getValue();
            }
        }

        return '';
    }

    /**
     * @param BaseSale $sale
     *
     * @return string
     */
    public function getQr($sale)
    {
        $client = $sale->getClient();
        $params = [
            $sale->getCompany()->getRuc(),
            $sale->getTipoDoc(),
            $sale->getSerie(),
            $sale->getCorrelativo(),
            number_format($sale->getMtoIGV(), 2, '.', ''),
            number_format($sale->getMtoImpVenta(), 2, '.', ''),
            $sale->getFechaEmision()->format('Y-m-d'),
            $client->getTipoDoc(),
            $client->getNumDoc(),
        ];
        $content = implode('|', $params).'|';

        return $this->getQrImage($content);
    }

    private function getQrImage($content)
    {
        $renderer = new Png();
        $renderer->setHeight(120);
        $renderer->setWidth(120);
        $renderer->setMargin(0);
        $writer = new Writer($renderer);
        $qrCode = $writer->writeString($content, 'UTF-8', ErrorCorrectionLevel::Q);

        return $qrCode;
    }
}

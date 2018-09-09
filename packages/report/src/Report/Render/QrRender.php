<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 08/09/2018
 * Time: 22:59.
 */

namespace Greenter\Report\Render;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Greenter\Model\Sale\BaseSale;

/**
 * Class QrRender.
 */
class QrRender
{
    /**
     * @param BaseSale $sale
     *
     * @return string
     */
    public function getImage($sale)
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

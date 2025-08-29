<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 08/09/2018
 * Time: 22:59.
 */

namespace Greenter\Report\Render;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Greenter\Model\Despatch\Despatch;
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

    /**
     * Summary of getImageDespatch
     * @param string $qr Link de la guía de remisión encontrada en el CDR
     * @return string
     */
    public function getImageDespatch(string $qr)
    {
        return $this->getQrImage($qr);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getQrUrl(string $url)
    {
        return $this->getQrImage($url);
    }

    private function getQrImage(string $content)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(120, 0),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        return $writer->writeString($content, 'UTF-8', ErrorCorrectionLevel::Q());
    }
}

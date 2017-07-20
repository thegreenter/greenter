<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Helper\ZipHelper;
use Greenter\Ws\Services\FeSunat;

/**
 * Trait FeSunatTrait
 * @package Tests\Greenter\Ws\Services
 */
trait FeSunatTrait
{
    private function getSender()
    {
        $sunat = new FeSunat('20600055519MODDATOS', 'moddatos');
        $sunat->setService(FeSunat::BETA);
        return $sunat;
    }

    private function assertXmlResponse($zipContent, $filename)
    {
        $helper = new ZipHelper();
        $content = $helper->decompress($zipContent, $filename);

        /**@var $this \PHPUnit_Framework_TestCase*/
        $this->assertContains('La Factura numero F001-00000001, ha sido aceptada', $content);
    }
}
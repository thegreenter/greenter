<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\FeSunat as SunatWs;
use Greenter\Ws\Services\WsSunatInterface;

/**
 * Trait FeSunatTrait
 * @package Tests\Greenter\Ws\Services
 */
trait FeSunatTrait
{
    /**
     * @return WsSunatInterface
     */
    private function getSender()
    {
        $sunat = new FeSunatFake();
        $sunat->setCrentials('20600055519MODDATOS', 'moddatos');
        $sunat->setService(SunatWs::BETA);
        return $sunat;
    }
}
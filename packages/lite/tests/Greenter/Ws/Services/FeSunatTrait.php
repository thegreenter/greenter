<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16
 */

namespace Tests\Greenter\Ws\Services;

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
}
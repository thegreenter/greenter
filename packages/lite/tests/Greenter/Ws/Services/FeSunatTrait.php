<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 21:16
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Ws\Services\ExtService;
use Greenter\Ws\Services\SunatEndpoints;

/**
 * Trait FeSunatTrait
 * @package Tests\Greenter\Ws\Services
 */
trait FeSunatTrait
{
    /**
     * @return ExtService
     */
    private function getSender()
    {
        $sunat = new ExtService();
        $sunat->setUrlWsdl(SunatEndpoints::WSDL_ENDPOINT);
        $sunat->setCredentials('20600055519MODDATOS', 'moddatos');
        $sunat->setService(SunatEndpoints::FE_BETA);
        return $sunat;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:39
 */

namespace Greenter\Ws\Services;

/**
 * Class CeSunat
 * @package Greenter\Ws\Services
 */
class CeSunat extends FeSunat
{
    /**
     * GUIA REMISION SERVICES
     */
    const GUIA_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
    const GUIA_PRODUCCION = 'https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';

    /**
     * RETENCION Y PERCEPCION SERVICES
     */
    const RETENCION_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService';
    const RETENCION_PRODUCCION = 'https://www.sunat.gob.pe/ol-ti-itemision-otroscpe-gem/billService';
}
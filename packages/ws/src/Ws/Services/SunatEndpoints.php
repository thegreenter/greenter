<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 15:24.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

/**
 * Class SunatEndpoints.
 */
final class SunatEndpoints
{
    /**
     *  FACTURACION SERVICES.
     */
    public const FE_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    public const FE_HOMOLOGACION = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
    public const FE_PRODUCCION = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    public const FE_CONSULTA_CDR = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService';

    /**
     * GUIA DE REMISION SERVICES.
     *
     * @deprecated use API endpoint
     */
    public const GUIA_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';
    /**
     * @deprecated use API endpoint
     */
    public const GUIA_PRODUCCION = 'https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';

    /**
     * RETENCION Y PERCEPCION SERVICES.
     */
    public const RETENCION_BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService';
    public const RETENCION_PRODUCCION = 'https://e-factura.sunat.gob.pe/ol-ti-itemision-otroscpe-gem/billService';

    /**
     * WSDL Uri.
     */
    public const WSDL_ENDPOINT = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:56
 */

namespace Greenter\Ws\Services;

/**
 * Class FeSunat
 * @package Greenter\Ws\Services
 */
class FeSunat extends BaseSunat
{
    const BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    const HOMOLOGACION  = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
    const PRODUCCION = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    const WSDL_ENDPOINT = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';

    public function __construct($user, $password)
    {
        parent::__construct($user, $password);
        parent::setUrlWsdl(FeSunat::WSDL_ENDPOINT);
    }

    public function send($filename, $content)
    {
        $client = parent::getClient();

        try {
            $response = $client->__soapCall('sendBill', [
                'fileName' => $filename,
                'contentFile' => $content,
            ]);
            return $response->applicationResponse;
//            $entry = readXml( $response->applicationResponse, 'R-20600055519-01-F001-00000001.xml');
//            if (!empty($entry)) {
//                header('Content-Type: text/xml');
//                echo $entry;
//            }

        }
        catch (\Exception $e) {
            return $client->__getLastResponse();
//    echo "<h2>Exception Error!</h2>";
//    echo $e->getMessage();
        }
    }
}
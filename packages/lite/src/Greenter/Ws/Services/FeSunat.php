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
    const BETA = '';
    const HOMOLOGACION  = '';
    const PRODUCCION = '';
    const WSDL_ENDPOINT = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';

    public function send()
    {
        $client = parent::getClient();

        try {
            $response = $client->__soapCall('sendBill', [
                'fileName' => '20551520634-01-F001-00000001.zip',
                'contentFile' => file_get_contents(''),
            ]);
//            $entry = readXml( $response->applicationResponse, 'R-20600055519-01-F001-00000001.xml');
//            if (!empty($entry)) {
//                header('Content-Type: text/xml');
//                echo $entry;
//            }

        }
        catch (\Exception $e) {
            header('Content-Type: text/xml');
            echo $client->__getLastResponse();
//    echo "<h2>Exception Error!</h2>";
//    echo $e->getMessage();
        }
    }
}
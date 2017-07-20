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
        $this->setUrlWsdl(FeSunat::WSDL_ENDPOINT);
    }

    public function send($filename, $content)
    {
        $client = parent::getClient();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->__soapCall('sendBill', [ 'parameters' => $params ]);
            return $response->applicationResponse;
//            $entry = readXml( $response->applicationResponse, 'R-20600055519-01-F001-00000001.xml');
//            if (!empty($entry)) {
//                header('Content-Type: text/xml');
//                echo $entry;
//            }

        }
        catch (\Exception $e) {
            // $client->__getLastResponse()
            return $e->getMessage();
        }
    }

    public function sendSummary($filename, $content)
    {
        $client = parent::getClient();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->__soapCall('sendSummary', [ 'parameters' => $params ]);
            return $response->ticket;
//            $entry = readXml( $response->applicationResponse, 'R-20600055519-01-F001-00000001.xml');
//            if (!empty($entry)) {
//                header('Content-Type: text/xml');
//                echo $entry;
//            }

        }
        catch (\Exception $e) {
            // $client->__getLastResponse()
            return $e->getMessage();
        }
    }

    public function getStatus($ticket)
    {
        $client = parent::getClient();

        try {
            $params = [
                'ticket' => $ticket,
            ];
            $response = $client->__soapCall('getStatus', [ 'parameters' => $params ]);
            return $response->statusResponse;
//            $entry = readXml( $response->applicationResponse, 'R-20600055519-01-F001-00000001.xml');
//            if (!empty($entry)) {
//                header('Content-Type: text/xml');
//                echo $entry;
//            }

        }
        catch (\SoapFault $fault) {
            // $client->__getLastResponse()
            // $fault->faultstring;
            return $fault->faultcode;
        }
    }
}
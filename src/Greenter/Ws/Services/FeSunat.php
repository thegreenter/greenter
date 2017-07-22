<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:56
 */

namespace Greenter\Ws\Services;
use Greenter\Helper\SunatErrorHelper;
use Greenter\Helper\ZipHelper;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\Error;

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

    /**
     * @param $filename
     * @param $content
     * @return BillResult
     */
    public function send($filename, $content)
    {
        $client = $this->getClient();
        $result = new BillResult();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->__soapCall('sendBill', [ 'parameters' => $params ]);

            $cdrZip = $response->applicationResponse;
            $result
                ->setCdrResponse($this->extractResponse($cdrZip))
                ->setCdrZip($cdrZip)
                ->setSuccess(true);
        }
        catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }

    public function sendSummary($filename, $content)
    {
        $client = $this->getClient();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->__soapCall('sendSummary', [ 'parameters' => $params ]);
            return $response->ticket;
        }
        catch (\Exception $e) {
            // $client->__getLastResponse()
            return $e->getMessage();
        }
    }

    public function getStatus($ticket)
    {
        $client = $this->getClient();

        try {
            $params = [
                'ticket' => $ticket,
            ];
            $response = $client->__soapCall('getStatus', [ 'parameters' => $params ]);
            return $response->statusResponse;
        }
        catch (\SoapFault $fault) {
            // $client->__getLastResponse()
            // $fault->faultstring;
            return $fault->faultcode;
        }
    }

    /**
     * Get error from Fault Exception.
     *
     * @param \SoapFault $fault
     * @return Error
     */
    private function getErrorFromFault(\SoapFault $fault)
    {
        $err = new Error();
        $code = $fault->faultcode;
        if ($code) {
            $err->setCode($code);
            $err->setMessage($fault->faultstring);
            return $err;
        }
        $code = preg_replace('/[^0-9]+/', '', $code);
        $search = new SunatErrorHelper();
        $msg = $search->getMessageByCode($code);
        $err->setCode($code);
        $err->setMessage($msg);
        return $err;
    }


    private function extractResponse($zipContent)
    {
        $zip = new ZipHelper();
        $xml = $zip->decompressLastFile($zipContent);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xp = new \DOMXPath($doc);
        $xp->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xp->registerNamespace('xr', 'urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2');
        $resp = $xp->query('/xr:ApplicationResponse/cac:DocumentResponse/cac:Response');

        $obj = $resp[0]->childNodes;
        $cdr = new CdrResponse();
        $cdr->setId($obj[0]->nodeValue)
            ->setCode($obj[1]->nodeValue)
            ->setDescription($obj[2]->nodeValue);

        return $cdr;
    }
}
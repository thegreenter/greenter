<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:56
 */

namespace Greenter\Ws\Services;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Ws\Reader\DomCdrReader;
use Greenter\Ws\Reader\XmlErrorReader;
use Greenter\Zip\ZipFactory;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\Error;

/**
 * Class FeSunat
 * @package Greenter\Ws\Services
 */
class FeSunat extends BaseSunat implements WsSunatInterface
{
    const BETA = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    const HOMOLOGACION  = 'https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService';
    const PRODUCCION = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    const WSDL_ENDPOINT = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';

    /**
     * FeSunat constructor.
     */
    public function __construct()
    {
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

    /**
     * @param string $filename
     * @param string $content
     * @return SummaryResult
     */
    public function sendSummary($filename, $content)
    {
        $client = $this->getClient();
        $result = new SummaryResult();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->__soapCall('sendSummary', [ 'parameters' => $params ]);
            $result
                ->setTicket($response->ticket)
                ->setSuccess(true);
        }
        catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }
        return $result;
    }

    /**
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket)
    {
        $client = $this->getClient();
        $result = new StatusResult();

        try {
            $params = [
                'ticket' => $ticket,
            ];
            $response = $client->__soapCall('getStatus', [ 'parameters' => $params ]);
            $status = $response->status;
            $cdrZip = $status->content;

            $result
                ->setCode($status->statusCode)
                ->setCdrResponse($this->extractResponse($cdrZip))
                ->setCdrZip($cdrZip)
                ->setSuccess(true);
        }
        catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }

    /**
     * Set Credentials for WebService Authentication.
     *
     * @param string $user
     * @param string $password
     */
    public function setCredentials($user, $password)
    {
       parent::setCredentials($user, $password);
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
        $fcode = $fault->faultcode;
        $code = preg_replace('/[^0-9]+/', '', $fcode);
        $msg = '';

        if ($code) {
            $msg = $this->getMessageError($code);
            $fcode = $code;
        } else {
            $code = preg_replace('/[^0-9]+/', '', $fault->faultstring);

            if ($code) {
                $msg = $this->getMessageError($code);
                $fcode = $code;
            }
        }

        if (!$msg) {
            $msg = isset($fault->detail) ? $fault->detail->message : $fault->faultstring;
        }

        $err->setCode($fcode);
        $err->setMessage($msg);

        return $err;
    }

    private function getMessageError($code)
    {
        $search = new XmlErrorReader();
        $msg = $search->getMessageByCode(intval($code));

        return $msg;
    }

    private function extractResponse($zipContent)
    {
        $zip = new ZipFactory();
        $xml = $zip->decompressLastFile($zipContent);
        $reader = new DomCdrReader();

        return $reader->getCdrResponse($xml);
    }
}
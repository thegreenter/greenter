<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;

/**
 * Class ExtService
 * @package Greenter\Ws\Services
 */
class ExtService extends BaseSunat
{
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
            $response = $client->call('getStatus', [ 'parameters' => $params ]);
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
     * @param string $ruc
     * @param string $tipo
     * @param string $serie
     * @param string $numero
     * @return BillResult
     */
    public function getCdrStatus($ruc, $tipo, $serie, $numero)
    {
        $client = $this->getClient();
        $result = new BillResult();

        try {
            $params = [
                'rucComprobante' => $ruc,
                'tipoComprobante' => $tipo,
                'serieComprobante' => $serie,
                'numeroComprobante' => $numero,
            ];
            $response = $client->call('getStatusCdr', [ 'parameters' => $params ]);
            $statusCdr =$response->statusCdr;

//            $code = $statusCdr->statusCode;
//            $msg = $statusCdr->statusMessage;
            $cdrZip = $statusCdr->content;
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

}
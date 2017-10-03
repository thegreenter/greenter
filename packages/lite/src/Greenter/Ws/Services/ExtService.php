<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\StatusCdrResult;
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
     * @return StatusCdrResult
     */
    public function getCdrStatus($ruc, $tipo, $serie, $numero)
    {
        $client = $this->getClient();
        $result = new StatusCdrResult();

        try {
            $params = [
                'rucComprobante' => $ruc,
                'tipoComprobante' => $tipo,
                'serieComprobante' => $serie,
                'numeroComprobante' => $numero,
            ];
            $response = $client->call('getStatusCdr', [ 'parameters' => $params ]);
            $statusCdr =$response->statusCdr;

            $result->setCode($statusCdr->statusCode)
                ->setMessage($statusCdr->statusMessage)
                ->setCdrZip($statusCdr->content)
                ->setSuccess(true);

            if ($statusCdr->content) {
                $result->setCdrResponse($this->extractResponse($statusCdr->content));
            }
        }
        catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }

}
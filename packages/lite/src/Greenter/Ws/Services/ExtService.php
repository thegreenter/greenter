<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM
 */

namespace Greenter\Ws\Services;

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
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM.
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\StatusCdrResult;
use Greenter\Model\Response\StatusResult;

/**
 * Class ExtService.
 */
class ExtService extends BaseSunat
{
    /**
     * @param string $ticket
     *
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
            $response = $client->call('getStatus', ['parameters' => $params]);
            $status = $response->status;
            $cdrZip = $status->content;
            $code = $status->statusCode;

            $result
                ->setCode($code)
                ->setSuccess(true);

            if ($code == '0' || $code == '99') {
                $result
                    ->setCdrResponse($this->extractResponse($cdrZip))
                    ->setCdrZip($cdrZip);

                $code = $result->getCdrResponse()->getCode();
            }

            if ($this->isExceptionCode($code)) {
                $this->loadErrorByCode($result, $code);
            }

        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }
}

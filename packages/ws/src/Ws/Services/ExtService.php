<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

use Exception;
use Greenter\Model\Response\Error;
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
     * @throws Exception
     */
    public function getStatus($ticket)
    {
        try {
            return $this->getStatusInternal($ticket);
        } catch (\SoapFault $e) {
            $result = new StatusResult();
            $result->setError($this->getErrorFromFault($e));

            return $result;
        }
    }

    private function getStatusInternal($ticket)
    {
        $params = [
            'ticket' => $ticket,
        ];

        $response = $this->getClient()->call('getStatus', ['parameters' => $params]);
        if (!isset($response->status)) {
            throw new Exception('Invalid getStatus service response.');
        }

        return $this->processResponse($response->status);
    }

    private function processResponse($status)
    {
        $originCode = $status->statusCode;
        $code = intval($originCode);

        $result = new StatusResult();
        $result->setCode($originCode);

        if ($this->isPending($code)) {
            $result->setError($this->getCustomError($originCode));

            return $result;
        }

        if ($this->isProcessed($code)) {
            $cdrZip = $status->content;
            $result
                ->setSuccess(true)
                ->setCdrResponse($this->extractResponse($cdrZip))
                ->setCdrZip($cdrZip);

            $code = $result->getCdrResponse()->getCode();
        }

        if ($this->isExceptionCode($code)) {
            $this->loadErrorByCode($result, $originCode);
        }

        return $result;
    }

    /**
     * @param string $code
     *
     * @return Error
     */
    private function getCustomError($code)
    {
        $error = new Error($code, 'El procesamiento del comprobante aún no ha terminado');

        return $error;
    }

    private function isProcessed($code)
    {
        return '0' == $code || '99' == $code;
    }

    private function isPending($code)
    {
        return '98' == $code;
    }
}

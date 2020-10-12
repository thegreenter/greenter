<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

use Greenter\Model\Response\Error;
use Greenter\Model\Response\StatusResult;
use Greenter\Services\InvalidServiceResponseException;
use SoapFault;

/**
 * Class ExtService.
 */
class ExtService extends BaseSunat
{
    /**
     * @param string $ticket
     *
     * @return StatusResult
     * @throws InvalidServiceResponseException
     */
    public function getStatus($ticket): StatusResult
    {
        try {
            return $this->getStatusInternal($ticket);
        } catch (SoapFault $e) {
            $result = new StatusResult();
            $result->setError($this->getErrorFromFault($e));

            return $result;
        }
    }

    /**
     * @param string|null $ticket
     * @return StatusResult
     * @throws SoapFault
     * @throws InvalidServiceResponseException
     */
    private function getStatusInternal($ticket): StatusResult
    {
        $params = [
            'ticket' => $ticket,
        ];

        $response = $this->getClient()->call('getStatus', ['parameters' => $params]);
        if (!isset($response->status)) {
            throw new InvalidServiceResponseException('Invalid getStatus service response.');
        }

        return $this->processResponse($response->status);
    }

    /**
     * @param object $status
     * @return StatusResult
     */
    private function processResponse($status): StatusResult
    {
        $originCode = $status->statusCode;
        $code = (int)$originCode;

        $result = new StatusResult();
        $result->setCode($originCode);

        if ($this->isPending($code)) {
            $result->setError($this->getCustomError($originCode));

            return $result;
        }

        if ($this->isProcessed($code)) {
            if (!isset($status->content) || empty($status->content)) {
                $result->setError(new Error(
                    CustomErrorCodes::CDR_NOTFOUND_CODE,
                    CustomErrorCodes::CDR_NOTFOUND_EXT_MSG)
                );

                return $result;
            }

            $cdrZip = $status->content;
            $result
                ->setSuccess(true)
                ->setCdrResponse($this->extractResponse((string)$cdrZip))
                ->setCdrZip($cdrZip);

            $code = (int)$result->getCdrResponse()->getCode();
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
    private function getCustomError($code): Error
    {
        return new Error($code, 'El procesamiento del comprobante aún no ha terminado');
    }

    private function isProcessed(int $code)
    {
        return 0 === $code || 99 === $code;
    }

    private function isPending(int $code)
    {
        return 98 === $code;
    }
}

<?php

declare(strict_types=1);

namespace Greenter\Api;

use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\Error;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Services\SenderInterface;
use Greenter\Sunat\GRE\Api\CpeApiInterface;
use Greenter\Sunat\GRE\ApiException;
use Greenter\Sunat\GRE\Model\CpeDocument;
use Greenter\Sunat\GRE\Model\CpeDocumentArchivo;
use Greenter\Sunat\GRE\Model\StatusResponse;
use Greenter\Ws\Services\BaseSunat;

class GreSender extends BaseSunat implements SenderInterface
{
    private CpeApiInterface $api;

    /**
     * @param CpeApiInterface $api
     */
    public function __construct(CpeApiInterface $api)
    {
        $this->api = $api;
    }

    public function send(?string $filename, ?string $content): ?BaseResult
    {
        $result = new SummaryResult();
        try {
            $zipContent = $this->compress($filename.'.xml', $content);
            $document = (new CpeDocument())
                ->setArchivo((new CpeDocumentArchivo())
                    ->setNomArchivo($filename.'.zip')
                    ->setArcGreZip(base64_encode($zipContent))
                    ->setHashZip(hash('sha256', $zipContent))
                );
            $response = $this->api->enviarCpe($filename, $document);
            $result
                ->setTicket($response->getNumTicket())
                ->setSuccess(true);
        } catch (ApiException $e) {
            $result->setError($this->processException($e));
        }

        return $result;
    }

    public function status(?string $ticket): StatusResult
    {
        $result = new StatusResult();
        try {
            $response = $this->api->consultarEnvio($ticket);

            return $this->processResponse($response);
        } catch (ApiException $e) {
            $result->setError($this->processException($e));
        }

        return $result;
    }

    /**
     * @param StatusResponse $status
     * @return StatusResult
     */
    private function processResponse(StatusResponse $status): StatusResult
    {
        $code = $status->getCodRespuesta();

        $result = new StatusResult();
        $result->setCode($code);

        $isPending = $code === '98';
        if ($isPending) {
            $result->setError(new Error($code, 'En proceso'));

            return $result;
        }

        $isCompleted = $code === '0' || $code === '99';
        if ($isCompleted) {
            if ($status->getError()) {
                $result->setError(
                    new Error(
                        $status->getError()->getNumError(),
                        $status->getError()->getDesError()
                    )
                );
            }

            if ($status->getIndCdrGenerado() === '1') {
                $cdrZip = base64_decode($status->getArcCdr());
                $result
                    ->setSuccess(true)
                    ->setCdrResponse($this->extractResponse((string)$cdrZip))
                    ->setCdrZip($cdrZip);
            }
        }

        return $result;
    }

    private function processException(ApiException $ex): Error
    {
        if ($ex->getCode() === 422) {
            /**@var $resp \Greenter\Sunat\GRE\Model\CpeErrorValidation */
            $resp = $ex->getResponseObject();
            foreach ($resp->getErrors() as $err) {
                return new Error($err->getCod(), $err->getMsg());
            }
        } elseif ($ex->getCode() === 500) {
            /**@var $resp \Greenter\Sunat\GRE\Model\CpeError */
            $resp = $ex->getResponseObject();
            return new Error($resp->getCod(), $resp->getMsg());
        }

        return new Error("API", $ex->getMessage());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

use Greenter\Model\Response\StatusCdrResult;
use SoapFault;

/**
 * Class ConsultCdrService.
 */
class ConsultCdrService extends BaseSunat
{
    /**
     * Obtiene el estado del comprobante.
     *
     * @param string $ruc
     * @param string $tipo
     * @param string $serie
     * @param int    $numero
     *
     * @return StatusCdrResult
     */
    public function getStatus(string $ruc, string $tipo, string $serie, int $numero)
    {
        return $this->getStatusResult('getStatus', 'status', $ruc, $tipo, $serie, $numero);
    }

    /**
     * Obtiene el CDR del comprobante.
     *
     * @param string $ruc
     * @param string $tipo
     * @param string $serie
     * @param int    $numero
     *
     * @return StatusCdrResult
     */
    public function getStatusCdr(string $ruc, string $tipo, string $serie, int $numero)
    {
        return $this->getStatusResult('getStatusCdr', 'statusCdr', $ruc, $tipo, $serie, $numero);
    }

    private function getStatusResult(string $method, string $resultName, string $ruc, string $tipo, string $serie, int $numero)
    {
        $result = new StatusCdrResult();

        try {
            $params = [
                'rucComprobante'    => $ruc,
                'tipoComprobante'   => $tipo,
                'serieComprobante'  => $serie,
                'numeroComprobante' => $numero,
            ];
            $response = $this->getClient()->call($method, ['parameters' => $params]);
            $statusCdr = $response->{$resultName};
            $this->loadFromResponse($result, $statusCdr);

        } catch (SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }

    private function loadFromResponse(StatusCdrResult $result, $statusCdr)
    {
        $code = $statusCdr->statusCode;
        $result->setCode($code)
            ->setMessage($statusCdr->statusMessage)
            ->setSuccess(true);

        if (isset($statusCdr->content)) {
            $result->setCdrZip($statusCdr->content)
                ->setCdrResponse($this->extractResponse((string)$statusCdr->content));
            $code = $result->getCdrResponse()->getCode();
        }

        if ($this->isExceptionCode((int)$code)) {
            $this->loadErrorByCode($result, $code);
        }
    }
}

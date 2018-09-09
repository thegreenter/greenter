<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:10 AM.
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\StatusCdrResult;

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
     * @param int $numero
     *
     * @return StatusCdrResult
     */
    public function getStatus($ruc, $tipo, $serie, $numero)
    {
        return $this->getStatusResult('getStatus', $ruc, $tipo, $serie, $numero);
    }

    /**
     * Obtiene el CDR del comprobante.
     *
     * @param string $ruc
     * @param string $tipo
     * @param string $serie
     * @param int $numero
     *
     * @return StatusCdrResult
     */
    public function getStatusCdr($ruc, $tipo, $serie, $numero)
    {
        return $this->getStatusResult('getStatusCdr', $ruc, $tipo, $serie, $numero);
    }

    private function getStatusResult($method, $ruc, $tipo, $serie, $numero)
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
            $response = $client->call($method, ['parameters' => $params]);
            $statusCdr = $response->statusCdr;

            $result->setCode($statusCdr->statusCode)
                ->setMessage($statusCdr->statusMessage)
                ->setCdrZip($statusCdr->content)
                ->setSuccess(true);

            if ($statusCdr->content) {
                $result->setCdrResponse($this->extractResponse($statusCdr->content));
            }
        } catch (\SoapFault $e) {
            $result->setError($this->getErrorFromFault($e));
        }

        return $result;
    }
}

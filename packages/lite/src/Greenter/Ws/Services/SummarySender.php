<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 10:05 AM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BaseResult;
use Greenter\Model\Response\SummaryResult;

/**
 * Class SummarySender
 * @package Greenter\Ws\Services
 */
class SummarySender extends BaseSunat implements SenderInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return BaseResult
     */
    public function send($filename, $content)
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
}
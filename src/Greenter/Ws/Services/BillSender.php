<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 09:59 AM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;

/**
 * Class BillSender
 * @package Greenter\Ws\Services
 */
class BillSender extends BaseSunat implements SenderInterface
{

    /**
     * @param string $filename
     * @param string $content
     * @return mixed
     */
    public function send($filename, $content)
    {
        $client = $this->getClient();
        $result = new BillResult();

        try {
            $params = [
                'fileName' => $filename,
                'contentFile' => $content,
            ];
            $response = $client->call('sendBill', [ 'parameters' => $params ]);

            $cdrZip = $response->applicationResponse;
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
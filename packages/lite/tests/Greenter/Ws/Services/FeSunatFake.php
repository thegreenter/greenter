<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/07/2017
 * Time: 12:42 PM
 */

namespace Tests\Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Ws\Services\WsSunatInterface;

class FeSunatFake implements WsSunatInterface
{

    /**
     * @param string $filename
     * @param string $content
     * @return BillResult
     */
    public function send($filename, $content)
    {
        $cdr = new CdrResponse();
        $cdr->setCode('0')
            ->setDescription('La Factura numero F001-00000001, ha sido aceptada')
            ->setId('F001-00000001');

        $result = new BillResult();
        $result->setCdrResponse($cdr)
            ->setSuccess(true);

        return $result;
    }

    /**
     * @param string $filename
     * @param string $content
     * @return SummaryResult
     */
    public function sendSummary($filename, $content)
    {
        $sum = new SummaryResult();
        $sum->setTicket('1500523236696')
            ->setSuccess(true);

        return $sum;
    }

    /**
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket)
    {
        $cdr = new CdrResponse();
        $cdr->setCode('0')
        ->setDescription('La documento 20600995805-RA-20170719-01, ha sido aceptado')
        ->setId('RA-20170719-01');

        $result = new StatusResult();
        $result->setCode('0')
            ->setCdrResponse($cdr)
            ->setSuccess(true);

        return $result;
    }

    public function setCrentials($user, $password)
    {
        if (empty($user) || empty($password)) {
            throw new \Exception('Not valid credentials');
        }
    }

    public function setService($service)
    {
        if (empty($service)) {
            throw new \Exception('Not valid url service');
        }
    }
}
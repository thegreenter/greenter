<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/07/2017
 * Time: 12:25 PM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;

/**
 * Interface WsSunat
 * @package Greenter\Ws\Services
 */
interface WsSunatInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return BillResult
     */
    public function send($filename, $content);

    /**
     * @param string $filename
     * @param string $content
     * @return SummaryResult
     */
    public function sendSummary($filename, $content);

    /**
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket);
}
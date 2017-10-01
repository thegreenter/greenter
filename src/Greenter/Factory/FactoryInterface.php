<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 15:31
 */

namespace Greenter\Factory;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;

/**
 * Interface FactoryInterface
 * @package Greenter\Factory
 */
interface FactoryInterface
{
    /**
     * @param DocumentInterface $document
     * @return BillResult
     */
    public function sendDocument(DocumentInterface $document);

    /**
     * @param DocumentInterface $document
     * @return SummaryResult
     */
    public function sendSummary(DocumentInterface $document);

    /**
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket);
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/09/2017
 * Time: 21:52
 */

namespace Greenter\Report;

use Greenter\Report\Model\Invoice;

/**
 * Interface PdfGenerator
 * @package Greenter\Report
 */
interface PdfGenerator
{
    /**
     * Generate Pdf from Invoice.
     *
     * @param Invoice $invoice
     * @return mixed
     */
    public function build(Invoice $invoice);

    /**
     * @param array $parameters
     */
    public function setParameters($parameters);
}
<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 04/10/2017
 * Time: 19:59
 */

namespace Greenter\Report;

use Greenter\Model\DocumentInterface;

/**
 * Interface ReportInterface
 * @package Greenter\Report
 */
interface ReportInterface
{
    /**
     * @param DocumentInterface $document
     * @param array $parameters
     * @return mixed
     */
    public function build(DocumentInterface $document, $parameters = []);
}
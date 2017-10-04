<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:08 PM
 */

namespace Greenter\Model\Summary;

/**
 * Class SummaryV2
 * @package Greenter\Model\Summary
 */
class SummaryV2 extends Summary
{
    /**
     * @Assert\Valid()
     * @var SummaryDetailV2[]
     */
    private $details;

    /**
     * @return SummaryDetailV2[]
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param SummaryDetailV2[] $details
     * @return SummaryV2
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }
}
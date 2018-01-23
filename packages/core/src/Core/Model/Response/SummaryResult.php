<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:19.
 */

namespace Greenter\Model\Response;

/**
 * Class SummaryResult.
 */
class SummaryResult extends BaseResult
{
    /**
     * @var string
     */
    protected $ticket;

    /**
     * @return string
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param string $ticket
     *
     * @return SummaryResult
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:19.
 */

declare(strict_types=1);

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
    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    /**
     * @param string $ticket
     *
     * @return $this
     */
    public function setTicket(?string $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}

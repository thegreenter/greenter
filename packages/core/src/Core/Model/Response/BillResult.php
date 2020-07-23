<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:12.
 */

declare(strict_types=1);

namespace Greenter\Model\Response;

/**
 * Class BillResult.
 */
class BillResult extends BaseResult
{
    /**
     * @var string
     */
    protected $cdrZip;

    /**
     * @var CdrResponse
     */
    protected $cdrResponse;

    /**
     * @return string
     */
    public function getCdrZip(): ?string
    {
        return $this->cdrZip;
    }

    /**
     * @param string $cdrZip
     *
     * @return BillResult
     */
    public function setCdrZip(?string $cdrZip): BillResult
    {
        $this->cdrZip = $cdrZip;

        return $this;
    }

    /**
     * @return CdrResponse
     */
    public function getCdrResponse(): ?CdrResponse
    {
        return $this->cdrResponse;
    }

    /**
     * @param CdrResponse $cdrResponse
     *
     * @return BillResult
     */
    public function setCdrResponse(?CdrResponse $cdrResponse): BillResult
    {
        $this->cdrResponse = $cdrResponse;

        return $this;
    }
}

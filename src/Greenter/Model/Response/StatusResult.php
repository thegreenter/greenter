<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:20
 */

namespace Greenter\Model\Response;

/**
 * Class StatusResult
 * @package Greenter\Model\Response
 */
class StatusResult extends BaseResult
{
    /**
     * StatusCode enviado por Sunat.
     * @var string
     */
    protected $code;

    /**
     * Indica si CDR existe o se encuentra en proceso.
     * @var string
     */
    protected $message;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return StatusResult
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCdrZip()
    {
        return $this->cdrZip;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return StatusResult
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $cdrZip
     * @return StatusResult
     */
    public function setCdrZip($cdrZip)
    {
        $this->cdrZip = $cdrZip;
        return $this;
    }

    /**
     * @return CdrResponse
     */
    public function getCdrResponse()
    {
        return $this->cdrResponse;
    }

    /**
     * @param CdrResponse $cdrResponse
     * @return StatusResult
     */
    public function setCdrResponse($cdrResponse)
    {
        $this->cdrResponse = $cdrResponse;
        return $this;
    }
}
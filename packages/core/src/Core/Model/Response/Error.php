<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:14.
 */

namespace Greenter\Model\Response;

/**
 * Class Error.
 */
class Error
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * Error constructor.
     * @param string $code
     * @param string $message
     */
    public function __construct($code = '', $message = '')
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Error
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
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
     *
     * @return Error
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:16
 */

namespace Greenter\Model\Response;

/**
 * Class BaseResult
 * @package Greenter\Model\Response
 */
class BaseResult
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var Error
     */
    protected $error;

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return BaseResult
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param Error $error
     * @return BaseResult
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
}
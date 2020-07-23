<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:16.
 */

declare(strict_types=1);

namespace Greenter\Model\Response;

/**
 * Class BaseResult.
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
     * BaseResult constructor.
     */
    public function __construct()
    {
        $this->success = false;
    }

    /**
     * @return bool
     */
    public function isSuccess(): ?bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return BaseResult
     */
    public function setSuccess(?bool $success): BaseResult
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return Error
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * @param Error $error
     *
     * @return BaseResult
     */
    public function setError(?Error $error): BaseResult
    {
        $this->error = $error;

        return $this;
    }
}

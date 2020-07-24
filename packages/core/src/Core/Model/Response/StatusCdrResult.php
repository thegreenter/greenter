<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 03/10/2017
 * Time: 12:55 PM.
 */

declare(strict_types=1);

namespace Greenter\Model\Response;

/**
 * Class StatusCdrResult.
 */
class StatusCdrResult extends BillResult
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
}

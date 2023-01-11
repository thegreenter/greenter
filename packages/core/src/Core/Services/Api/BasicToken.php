<?php

declare(strict_types=1);

namespace Greenter\Services\Api;

use DateTimeInterface;

class BasicToken
{
    private ?string $value;
    private ?DateTimeInterface $expire;

    /**
     * @param string|null $value
     * @param DateTimeInterface|null $expire
     */
    public function __construct(?string $value, ?DateTimeInterface $expire)
    {
        $this->value = $value;
        $this->expire = $expire;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return BasicToken
     */
    public function setValue(?string $value): BasicToken
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getExpire(): ?DateTimeInterface
    {
        return $this->expire;
    }

    /**
     * @param DateTimeInterface|null $expire
     * @return BasicToken
     */
    public function setExpire(?DateTimeInterface $expire): BasicToken
    {
        $this->expire = $expire;
        return $this;
    }
}

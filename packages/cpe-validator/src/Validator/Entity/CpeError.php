<?php

declare(strict_types=1);

namespace Greenter\Validator\Entity;

class CpeError
{
    /**
     * @var string|null
     */
    private $code;
    /**
     * @var string|null
     */
    private $message;
    /**
     * @var string|null
     */
    private $level;
    /**
     * @var string|null
     */
    private $nodePath;
    /**
     * @var string|null
     */
    private $nodeValue;

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return CpeError
     */
    public function setCode(?string $code): CpeError
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return CpeError
     */
    public function setMessage(?string $message): CpeError
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @param string|null $level
     * @return CpeError
     */
    public function setLevel(?string $level): CpeError
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNodePath(): ?string
    {
        return $this->nodePath;
    }

    /**
     * @param string|null $nodePath
     * @return CpeError
     */
    public function setNodePath(?string $nodePath): CpeError
    {
        $this->nodePath = $nodePath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNodeValue(): ?string
    {
        return $this->nodeValue;
    }

    /**
     * @param string|null $nodeValue
     * @return CpeError
     */
    public function setNodeValue(?string $nodeValue): CpeError
    {
        $this->nodeValue = $nodeValue;
        return $this;
    }
}

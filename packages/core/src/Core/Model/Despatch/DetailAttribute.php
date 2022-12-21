<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Class DetailAttribute.
 */
class DetailAttribute
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

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
     * @return DetailAttribute
     */
    public function setCode(?string $code): DetailAttribute
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return DetailAttribute
     */
    public function setName(?string $name): DetailAttribute
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return DetailAttribute
     */
    public function setValue(?string $value): DetailAttribute
    {
        $this->value = $value;

        return $this;
    }
}

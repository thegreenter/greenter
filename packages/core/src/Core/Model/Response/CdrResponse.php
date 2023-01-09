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
 * Class CdrResponse.
 */
class CdrResponse
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string[]
     */
    protected $notes;

    /**
     * @var string|null
     */
    protected $reference;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return CdrResponse
     */
    public function setId(?string $id): CdrResponse
    {
        $this->id = $id;

        return $this;
    }

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
     * @return CdrResponse
     */
    public function setCode(?string $code): CdrResponse
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return CdrResponse
     */
    public function setDescription(?string $description): CdrResponse
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getNotes(): ?array
    {
        return $this->notes;
    }

    /**
     * @param string[] $notes
     *
     * @return CdrResponse
     */
    public function setNotes(?array $notes): CdrResponse
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     */
    public function setReference(?string $reference): CdrResponse
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccepted()
    {
        $code = (int)$this->getCode();

        return $code === 0 || $code >= 4000;
    }
}

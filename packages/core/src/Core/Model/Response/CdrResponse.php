<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:12.
 */

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
     * @return bool
     */
    public function isAccepted()
    {
        $code = intval($this->getCode());

        return $code === 0 || $code >= 4000;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return CdrResponse
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return CdrResponse
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return CdrResponse
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string[] $notes
     *
     * @return CdrResponse
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }
}

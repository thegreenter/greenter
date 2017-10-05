<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/07/2017
 * Time: 23:34
 */

namespace Greenter\Model\Sale;

use Greenter\Xml\Validator\LegendValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Legend
 * @package Greenter\Model\Sale
 */
class Legend
{
    use LegendValidator;

    /**
     * @Assert\Length(
     *     min="4",
     *     max="4"
     * )
     * @var string
     */
    private $code;

    /**
     * @Assert\Length(max="100")
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Legend
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Legend
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}
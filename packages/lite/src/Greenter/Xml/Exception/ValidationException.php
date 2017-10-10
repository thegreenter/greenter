<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:10
 */

namespace Greenter\Xml\Exception;

/**
 * Class ValidationException
 * @package Greenter\Xml\Exception
 */
class ValidationException extends \Exception
{
    /**
     * @var array
     */
    public $validations;

    /**
     * ValidationException constructor.
     * @param array $validations
     */
    public function __construct($validations)
    {
        $this->validations = $validations;
    }
}
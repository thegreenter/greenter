<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:10
 */

namespace Greenter\Validator;

/**
 * Class ValidationException
 * @package Greenter\Validator
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
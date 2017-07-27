<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:10
 */

namespace Greenter\Xml\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException
 * @package Greenter\Xml\Exception
 */
class ValidationException extends \Exception
{
    /**
     * @var ConstraintViolationListInterface
     */
    public $validations;

    /**
     * ValidationException constructor.
     * @param ConstraintViolationListInterface $validations
     */
    public function __construct(ConstraintViolationListInterface $validations)
    {
        $this->validations = $validations;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 25/01/2018
 * Time: 02:24 PM
 */

declare(strict_types=1);

namespace Greenter\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CodeUnit extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The value {{ value }} is not a valid unit code.';
}

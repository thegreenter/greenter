<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 27/01/2018
 * Time: 20:24.
 */

namespace Greenter\Validator;

/**
 * Interface ErroCodeProviderInterface.
 */
interface ErroCodeProviderInterface
{
    /**
     * @return array
     */
    public function getAll();

    /**
     * @param string $code
     *
     * @return string
     */
    public function getValue($code);
}

<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 22/07/2017
 * Time: 16:08.
 */

namespace Greenter\Ws\Reader;

/**
 * Interface ErrorReaderInterface.
 */
interface ErrorReaderInterface
{
    /**
     * Get Error Message by code.
     *
     * @param string $code
     *
     * @return string
     */
    public function getMessageByCode($code);
}

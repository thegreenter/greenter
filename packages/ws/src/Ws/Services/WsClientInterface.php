<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 03/10/2017
 * Time: 09:46 AM.
 */

namespace Greenter\Ws\Services;

/**
 * Interface WsClientInterface.
 */
interface WsClientInterface
{
    /**
     * @param string $function
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function call($function, $arguments);
}

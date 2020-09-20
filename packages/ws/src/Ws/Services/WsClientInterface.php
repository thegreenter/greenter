<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 03/10/2017
 * Time: 09:46 AM.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

use SoapFault;

/**
 * Interface WsClientInterface.
 */
interface WsClientInterface
{
    /**
     * @param string $function
     * @param mixed $arguments
     *
     * @throws SoapFault
     * @return mixed
     */
    public function call($function, $arguments);
}

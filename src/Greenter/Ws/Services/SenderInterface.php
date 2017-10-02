<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 09:58 AM
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BaseResult;

/**
 * Interface SenderInterface
 * @package Greenter\Ws\Services
 */
interface SenderInterface
{
    /**
     * @param string $filename
     * @param string $content
     * @return BaseResult
     */
    public function send($filename, $content);
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 11:03 AM
 */

namespace Tests\Greenter\Factory;

use Greenter\Model\Response\BaseResult;
use Greenter\Ws\Services\SenderInterface;

/**
 * Class FakeSender
 * @package Tests\Greenter\Factory
 */
class FakeSender implements SenderInterface
{

    /**
     * @param string $filename
     * @param string $content
     * @return BaseResult
     */
    public function send($filename, $content)
    {
        echo 'Sending Zip: ' . $filename;

        return (new BaseResult())
            ->setSuccess(true);
    }
}
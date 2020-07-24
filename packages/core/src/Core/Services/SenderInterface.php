<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 02/10/2017
 * Time: 09:58 AM.
 */

declare(strict_types=1);

namespace Greenter\Services;

use Greenter\Model\Response\BaseResult;

/**
 * Interface SenderInterface.
 */
interface SenderInterface
{
    /**
     * Send document.
     *
     * @param string $filename Filename
     * @param string $content  Content File
     *
     * @return BaseResult
     */
    public function send(?string $filename, ?string $content): ?BaseResult;
}

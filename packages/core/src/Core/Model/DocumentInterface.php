<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:31.
 */

declare(strict_types=1);

namespace Greenter\Model;

/**
 * Interface DocumentInterface.
 */
interface DocumentInterface
{
    /**
     * Get Name for Document.
     *
     * @return string
     */
    public function getName(): string;
}

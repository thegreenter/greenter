<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 22/07/2017
 * Time: 15:38.
 */

declare(strict_types=1);

namespace Greenter\Ws\Reader;

use Greenter\Model\Response\CdrResponse;

/**
 * Interface CdrReaderInterface.
 */
interface CdrReaderInterface
{
    /**
     * Get Cdr using DomDocument.
     *
     * @param string $xml
     *
     * @return CdrResponse|null
     */
    public function getCdrResponse(?string $xml): ?CdrResponse;
}

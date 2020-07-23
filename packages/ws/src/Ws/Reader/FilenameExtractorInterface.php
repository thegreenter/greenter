<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 24/01/2019
 * Time: 16:03.
 */

declare(strict_types=1);

namespace Greenter\Ws\Reader;

/**
 * Interface FilenameExtractorInterface.
 */
interface FilenameExtractorInterface
{
    /**
     * @param \DOMDocument|string $content
     *
     * @return string|null
     */
    public function getFilename($content): ?string;
}

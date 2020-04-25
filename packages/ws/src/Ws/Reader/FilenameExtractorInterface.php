<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 24/01/2019
 * Time: 16:03.
 */

namespace Greenter\Ws\Reader;

/**
 * Interface FilenameExtractorInterface.
 */
interface FilenameExtractorInterface
{
    /**
     * @param \DOMDocument|string $content
     *
     * @return string
     */
    public function getFilename($content);
}

<?php
/**
 * Created by PhpStorm.
 * User: LPALQUILER-11
 * Date: 24/08/2018
 * Time: 17:37.
 */

namespace Greenter\Zip;

/**
 * Interface CompressInterface.
 */
interface CompressInterface
{
    /**
     * Compress File.
     *
     * @param string $filename
     * @param string $content
     *
     * @return string
     */
    public function compress($filename, $content);
}

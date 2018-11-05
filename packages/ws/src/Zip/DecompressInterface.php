<?php
/**
 * Created by PhpStorm.
 * User: LPALQUILER-11
 * Date: 24/08/2018
 * Time: 17:40.
 */

namespace Greenter\Zip;

/**
 * Interface DecompressInterface.
 */
interface DecompressInterface
{
    /**
     * Extract files.
     *
     * @param string        $content
     * @param callable|null $filter
     *
     * @return array
     */
    public function decompress($content, callable $filter = null);
}

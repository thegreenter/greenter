<?php
/**
 * Created by PhpStorm.
 * User: LPALQUILER-11
 * Date: 24/08/2018
 * Time: 17:37.
 */

declare(strict_types=1);

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
    public function compress(?string $filename, ?string $content): ?string;
}

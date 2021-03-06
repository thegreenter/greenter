<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:00.
 */

namespace Greenter\Zip;

use PhpZip\Constants\ZipCompressionMethod;
use PhpZip\ZipFile;

/**
 * Class ZipFile.
 */
class ZipFly implements CompressInterface, DecompressInterface
{
    /**
     * Comprime el contenido del archivo con el nombre especifico y retorna el contenido del zip.
     *
     * @param string $filename
     * @param string $content
     *
     * @return string|null
     */
    public function compress(?string $filename, ?string $content): ?string
    {
        $zipFile = new ZipFile();
        $zipFile->addFromString($filename, $content, ZipCompressionMethod::DEFLATED);
        $zip = $zipFile->outputAsString();
        $zipFile->close();

        return $zip;
    }

    /**
     * Extract files by filter.
     *
     * @param string        $content
     * @param callable|null $filter
     *
     * @return array
     */
    public function decompress(?string $content, callable $filter = null): ?array
    {
        $zipFile = new ZipFile();
        $zipFile->openFromString($content);

        $output = [];
        if ($zipFile->count() > 0) {
            $output = iterator_to_array($this->getFiles($zipFile, $filter));
        }

        $zipFile->close();

        return $output;
    }

    /**
     * @param callable|null $filter
     */
    private function getFiles(ZipFile $zip, ?callable $filter)
    {
        $entries = $zip->getEntries();
        foreach ($entries as $entry) {
            $filename = $entry->getName();
            if (!$filter || $filter($filename)) {
                yield [
                    'filename' => $filename,
                    'content' => $zip->getEntryContents($filename),
                ];
            }
        }
    }
}

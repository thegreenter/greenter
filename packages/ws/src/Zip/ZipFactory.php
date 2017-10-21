<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 12:23
 */

namespace Greenter\Zip;

use ZipArchive;

/**
 * Class ZipFactory
 * @package Greenter\Zip
 */
final class ZipFactory
{
    /**
     * Comprime el contenido del archivo con el nombre especifico y retorna el contenido del zip.
     *
     * @param string $filename
     * @param string $content
     * @return string
     */
    public function compress($filename, $content)
    {
        $archive = new ZipFile();
        $archive->addFile($content, $filename);

        return $archive->file();
    }

    /**
     * Retorna el contenido del archivo especificado dentro del zip.
     *
     * @param string $zipContent
     * @param string $fileToExtract
     * @return string
     */
    public function decompress($zipContent, $fileToExtract)
    {
        $temp = tempnam(sys_get_temp_dir(),time() . '.zip');
        file_put_contents($temp, $zipContent);
        $zip = new ZipArchive;
        $output = "";
        if ($zip->open($temp) === true) {
            $output = $zip->getFromName($fileToExtract);
        }
        $zip->close();
        unlink($temp);

        return $output;
    }

    /**
     * Retorna el contenido del ultimo archivo dentro del zip.
     *
     * @param string $zipContent
     * @return string
     */
    public function decompressLastFile($zipContent)
    {
        $temp = tempnam(sys_get_temp_dir(),time() . '.zip');
        file_put_contents($temp, $zipContent);
        $zip = new ZipArchive;
        $output = "";
        if (!$zip->open($temp)) {
            return $output;
        }

        if ($zip->numFiles > 0) {
            $output = $zip->getFromIndex($zip->numFiles - 1);
        }

        $zip->close();
        unlink($temp);

        return $output;
    }
}
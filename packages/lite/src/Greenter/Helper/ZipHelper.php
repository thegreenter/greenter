<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 12:23
 */

namespace Greenter\Helper;

use ZipArchive;

/**
 * Class ZipHelper
 * @package Greenter\Helper
 */
final class ZipHelper
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
     * Retorna el contenido del archivo dentro del zip.
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
}
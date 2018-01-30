<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:21 PM.
 */

namespace Greenter\Report\Filter;

/**
 * Class ImageFilter.
 */
class ImageFilter
{
    const PNG_HEAD = "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A";
    const JPEG_HEAD = "\xFF\xD8\xFF";
    const GIF_HEAD = "GIF";

    public function toBase64($image, $mime = '')
    {
        if (empty($mime)) {
            $mime = $this->getMimeType($image);
        }
        $content = base64_encode($image);

        return 'data:image/'.$mime.';base64,'.$content;
    }

    public function getMimeType($raw)
    {
        $text = substr($raw, 0, 8);
        if ($text == "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A"){
            return 'png';
        }

        $text = substr($text, 0, 3);
        if ($text == self::GIF_HEAD) {
            return 'gif';
        }

        return 'jpeg';
    }
}

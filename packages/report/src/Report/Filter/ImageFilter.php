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
    const IMAGE_EMBED_PART = 'data:image/png;base64,';

    public function toBase64($image)
    {
        $content = base64_encode($image);

        return self::IMAGE_EMBED_PART.$content;
    }
}

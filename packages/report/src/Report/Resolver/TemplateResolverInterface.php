<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/02/2019
 * Time: 21:24
 */

namespace Greenter\Report\Resolver;

use Greenter\Model\DocumentInterface;

interface TemplateResolverInterface
{
    /**
     * @param DocumentInterface $document
     * @return string
     */
    function getTemplate($document);
}
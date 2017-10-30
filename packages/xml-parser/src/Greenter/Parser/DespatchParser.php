<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 30/10/2017
 * Time: 05:33 PM
 */

namespace Greenter\Xml\Parser;

use Greenter\Model\DocumentInterface;
use Greenter\Parser\DocumentParserInterface;

/**
 * Class DespatchParser
 * @package Greenter\Xml\Parser
 */
class DespatchParser implements DocumentParserInterface
{

    /**
     * @param $value
     * @return DocumentInterface
     */
    public function parse($value)
    {
        throw new \Exception('no implement');
    }
}
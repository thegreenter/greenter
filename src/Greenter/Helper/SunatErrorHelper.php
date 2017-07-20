<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 19/07/2017
 * Time: 19:46
 */

namespace Greenter\Helper;

/**
 * Class SunatErrorHelper
 * @package Greenter\Helper
 */
class SunatErrorHelper
{
    private $xmlErrorFile = __DIR__ . '/../Resources/CodeErrors.xml';

    /**
     * Get Message by Code.
     *
     * @param string $code
     * @return string
     */
    public function getMessageByCode($code)
    {

        $doc = new \DOMDocument();
        $doc->load($this->xmlErrorFile);
        $xpath = new \DOMXPath($doc);
        $nodes = $xpath->query("/errors/error[@code='$code']");

        if ($nodes->length !== 1) {
            return '';
        }

        return $nodes[0]->nodeValue;
    }

    /**
     * Cambia el archivo de busqueda de errores por defecto.
     *
     * @param $xmlErrorFile
     * @return $this
     * @throws \Exception
     */
    public function setXmlErrorFile($xmlErrorFile)
    {
        if (!file_exists($xmlErrorFile)) {
            throw new \Exception("Archivo de errores no existe");
        }
        $this->xmlErrorFile = $xmlErrorFile;
        return $this;
    }
}
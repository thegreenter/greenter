<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 17/07/2017
 * Time: 23:39.
 */

namespace Greenter\Model\Sale;

/**
 * Class Document.
 */
class Document
{
    /**
     * @var string
     */
    private $tipoDoc;

    /**
     * @var string
     */
    private $nroDoc;

    /**
     * @return string
     */
    public function getTipoDoc()
    {
        return $this->tipoDoc;
    }

    /**
     * @param string $tipoDoc
     *
     * @return Document
     */
    public function setTipoDoc($tipoDoc)
    {
        $this->tipoDoc = $tipoDoc;

        return $this;
    }

    /**
     * @return string
     */
    public function getNroDoc()
    {
        return $this->nroDoc;
    }

    /**
     * @param string $nroDoc
     *
     * @return Document
     */
    public function setNroDoc($nroDoc)
    {
        $this->nroDoc = $nroDoc;

        return $this;
    }
}

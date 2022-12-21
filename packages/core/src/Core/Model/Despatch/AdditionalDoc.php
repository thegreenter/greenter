<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Class AdditionalDoc.
 */
class AdditionalDoc
{
    /**
     * Tipo de documento (Descripción)
     *
     * @var string
     */
    private $tipoDesc;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $nro;

    /**
     * RUC Emisor
     *
     * @var string
     */
    private $emisor;

    /**
     * @return string
     */
    public function getTipoDesc(): ?string
    {
        return $this->tipoDesc;
    }

    /**
     * @param string|null $tipoDesc
     * @return AdditionalDoc
     */
    public function setTipoDesc(?string $tipoDesc): AdditionalDoc
    {
        $this->tipoDesc = $tipoDesc;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    /**
     * @param string|null $tipo
     * @return AdditionalDoc
     */
    public function setTipo(?string $tipo): AdditionalDoc
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getNro(): string
    {
        return $this->nro;
    }

    /**
     * @param string|null $nro
     * @return AdditionalDoc
     */
    public function setNro(?string $nro): AdditionalDoc
    {
        $this->nro = $nro;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmisor(): ?string
    {
        return $this->emisor;
    }

    /**
     * @param string|null $emisor
     * @return AdditionalDoc
     */
    public function setEmisor(?string $emisor): AdditionalDoc
    {
        $this->emisor = $emisor;
        return $this;
    }
}